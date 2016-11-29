<?php
/**
 * Email class file
 * @TODO: Decrease Overall complexity
 * @TODO: Consider refactoring to keep number of methods under 10
 */
class Mailer extends CApplicationComponent
{
    /**
     * Delivery methods
     */
    const DELIVERY_PHP = 1;
    const DELIVERY_SMTP = 2;
    const DELIVERY_MANDRILL = 3;

    /**
     * @var string Delivery type
     */
    public $delivery = Mailer::DELIVERY_MANDRILL;

    /**
     * @var string from address
     */
    public $from;

    /**
     * @var string from name
     */
    public $fromName;

    /**
     * @var string to address
     */
    public $to;

    /**
     * @var string to name
     */
    public $toName;

    /**
     * @var string Email subject
     */
    public $subject;

    /**
     * @var string Main content
     */
    public $message;

    /**
     * @var PHPMailer mailer class
     */
    private $_mailer;

    /**
     * @var array Data
     */
    private $_data;

    /**
     * Constructor
     * @param array $data optional
     */
    public function __construct($data = array())
    {
        $this->_mailer = new PHPMailer;
        foreach ($data as $key => $value) {
            $this->_data[$key] = !empty($value) ? $value : 'Not Set';
        }
    }

    /**
     * Sends email
     */
    public function send()
    {
        $params = Yii::app()->params;
        switch ($this->delivery) {
            case Mailer::DELIVERY_SMTP:
                $this->_mailer->isSMTP();
                $this->_mailer->SMTPAuth = $params['smtpAuth'];
                $this->_mailer->SMTPSecure = $params['smtpSecure'];
                $this->_mailer->Host = $params['smtpHost'];
                $this->_mailer->Port = $params['smtpPort'];
                $this->_mailer->Username = $params['smtpUser'];
                $this->_mailer->Password = $params['smtpPassword'];
                break;
            case Mailer::DELIVERY_MANDRILL:
                $this->_mailer = new MandrillEmailWrapper($params['mdApiKey']);
                $this->_mailer->setData($this->_data);
                break;
            case Mailer::DELIVERY_PHP:
            default:
                $this->_mailer->isMail();
        }

        $this->_mailer->setFrom($this->from, $this->fromName);

        // Check test mode
        if ($params['emailTestMode']) {
            $this->_mailer->addAddress('info@boogi.co', $this->toName);
        } else {
            $this->_mailer->addAddress($this->to, $this->toName);
        }

        $this->_mailer->Subject = $this->subject;
        $this->_mailer->msgHTML($this->message);

        // Send copy to admins
        if ($params['isDebug']) {
            $this->_mailer->addBCC('info@boogi.co', $this->toName);

            // Send booking copy to root
            if ($this->_data['template_id'] == MCMDBridge::PROMOTER_BOOKING_SEND) {
                $this->_mailer->addBCC('info@boogi.co', 'Booking Admin');
            }
        }

        if ($params['sendEmail'] && !$this->_mailer->send()) {
            Yii::log($this->_mailer->ErrorInfo, CLogger::LEVEL_ERROR, 'email');
            return 0;
        }

        Mailer::log($this->to, $this->_data['template_id'], $this->_mailer->getFullData());
        return 1;
    }

    public function getError()
    {
        $this->_mailer->ErrorInfo;
    }

    public static function sendRegisterEmail($data)
    {
        if (!isset($data['email']) || !isset($data['name'])) {
            return false;
        }

        $data['template_id'] = MCMDBridge::PROMOTER_REGISTRATION;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'Welcome to Boogi!';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/signup', array('name' => $data['name'], 'address' => $data['email']));
        }

        return $email->send();
    }

    public static function sendResetPasswordEmail($data)
    {
        $data['template_id'] = MCMDBridge::USER_RESET_PASSWORD;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'Password Recovery';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/reset-password', array('link' => $data['link']));
        }

        return $email->send();
    }

    public static function sendBookingEmailsByBookingId($promoter, $booking_id)
    {
        // Compile data
        $artistGig = ArtistGig::model()->find('id = :id', array('id' => $booking_id));

        $result = self::sendBookingEmailToPromoter(array(
            'name'          => $promoter->name,
            'email'         => $promoter->user->email,
            'artist'        => $artistGig->artist->name,
            'date'          => $artistGig->gig->getDate(),
            'gig'           => $artistGig->gig->name,
            'gigtype'       => $artistGig->gig->getType(),
            'venue'         => $artistGig->gig->venue->name,
            'capacity'      => $artistGig->gig->capacity . ' ppl',
            'city'          => $artistGig->gig->venue->city,
            'country'       => $artistGig->gig->venue->country->name,
            'setstart'      => date('H:i', strtotime($artistGig->datetime_from)),
            'setend'        => date('H:i', strtotime($artistGig->datetime_to)),
            'price'         => $artistGig->price,
            'currency'      => $artistGig->getCurrency(),
            'transfer'      => $artistGig->getTransferType(),
            'accommodation' => $artistGig->getAccommodation(),
        ));

        $result += self::sendBookingEmailToArtist(array(
            'name'          => $artistGig->artist->name,
            'email'         => $artistGig->artist->user->email,
            'image'         => $artistGig->artist->getImageTag(),
            'promoter'      => $promoter->name,
        ));

        return $result == 2 ? 1 : 0;
    }

    public static function sendAccountBookingEmails($promoter, $account)
    {
        if ($account) {
            foreach ($account->user->gigs as $gig) {
                foreach ($gig->artistGigs as $booking) {
                    Mailer::sendBookingEmailsByBookingId($promoter, $booking->id);
                }
            }
        }
    }

    public static function sendBookingEmailToPromoter($data)
    {
        $data['template_id'] = MCMDBridge::PROMOTER_BOOKING_SEND;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'Your Booking Offer Is Sent';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-request', $data);
        }

        return $email->send();
    }

    public static function sendBookingEmailToArtist($data)
    {
        $data['template_id'] = MCMDBridge::ARTIST_BOOKING_REQUEST;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'New Booking Request';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-request', $data);
        }

        return $email->send();
    }

    public static function sendBookingConfirmEmailToArtist($artist_id, $gig_id)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $gig_id));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $artist_id));
        $data = array(
            'name'      => $artist->name,
            'email'     => $artist->user->email,
            'image'     => $artist->getImageTag(),
            'promoter'  => $promoter->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate()
        );

        $data['template_id'] = MCMDBridge::PROMOTER_BOOKING_CONFIRM;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = $promoter->name . ' Confirmed Booking Request';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-confirm', $data);
        }

        return $email->send();
    }

    public static function sendBookingAcceptEmailToPromoter($artist_id, $gig_id)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $gig_id));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $artist_id));
        $data = array(
            'name'      => $promoter->name,
            'email'     => $promoter->user->email,
            'image'     => $promoter->getImageTag(),
            'artist'    => $artist->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate()
        );

        $data['template_id'] = MCMDBridge::ARTIST_BOOKING_ACCEPT;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = $artist->name . ' Accepted Your Booking Request';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-confirm', $data);
        }

        return $email->send();
    }

    public static function sendBookingAdjustEmailToPromoter($artist_id, $gig_id)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $gig_id));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $artist_id));
        $data = array(
            'name'      => $promoter->name,
            'email'     => $promoter->user->email,
            'image'     => $promoter->getImageTag(),
            'artist'    => $artist->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate()
        );

        $data['template_id'] = MCMDBridge::PROMOTER_BOOKING_ADJUST;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = $artist->name . ' Booking Request Change';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-adjust', $data);
        }

        return $email->send();
    }

    public static function sendBookingAdjustEmailToArtist($artist_id, $gig_id)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $gig_id));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $artist_id));
        $data = array(
            'name'      => $artist->name,
            'email'     => $artist->user->email,
            'image'     => $artist->getImageTag(),
            'promoter'  => $promoter->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate()
        );

        $data['template_id'] = MCMDBridge::ARTIST_BOOKING_ADJUST;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = $promoter->name . ' Booking Request Change';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-adjust', $data);
        }

        return $email->send();
    }

    public static function sendBookingRejectEmailToPromoter($artist_id, $gig_id)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $gig_id));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $artist_id));
        $data = array(
            'name'      => $promoter->name,
            'email'     => $promoter->user->email,
            'image'     => $promoter->getImageTag(),
            'artist'    => $artist->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate()
        );

        $data['template_id'] = MCMDBridge::PROMOTER_BOOKING_REJECT;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = $artist->name . ' Rejected Your Booking Request';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-reject', $data);
        }

        return $email->send();
    }

    public static function sendBookingRejectEmailToArtist($artist_id, $gig_id)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $gig_id));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $artist_id));
        $data = array(
            'name'      => $artist->name,
            'email'     => $artist->user->email,
            'image'     => $artist->getImageTag(),
            'promoter'  => $promoter->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate()
        );

        $data['template_id'] = MCMDBridge::ARTIST_BOOKING_REJECT;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = $promoter->name . ' Rejected Booking Request';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-reject', $data);
        }

        return $email->send();
    }

    public static function sendBookingMessageEmailToPromoter($data)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $data['gig_id']));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $data['artist_id']));
        $data = array(
            'name'      => $promoter->name,
            'email'     => $promoter->user->email,
            'image'     => $promoter->getImageTag(),
            'artist'    => $artist->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate(),
            'message'   => $data['message']
        );

        $data['template_id'] = MCMDBridge::PROMOTER_BOOKING_MESSAGE;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'New Message From ' . $artist->name;

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-message', $data);
        }

        return $email->send();
    }

    public static function sendBookingMessageEmailToArtist($data)
    {
        $gig = Gig::model()->find('id = :id', array('id' => $data['gig_id']));
        $promoter = $gig->user->promoter();
        if (!$promoter) {
            return false;
        }

        $artist = Artist::model()->find('id = :id', array('id' => $data['artist_id']));
        $data = array(
            'name'      => $artist->name,
            'email'     => $artist->user->email,
            'image'     => $artist->getImageTag(),
            'promoter'  => $promoter->name,
            'gig'       => $gig->name,
            'date'      => $gig->getDate(),
            'message'   => $data['message']
        );

        $data['template_id'] = MCMDBridge::ARTIST_BOOKING_MESSAGE;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'New Message From ' . $promoter->name;

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/booking-message', $data);
        }

        return $email->send();
    }

    public static function sendRetentionEmail($data)
    {
        $data['template_id'] = MCMDBridge::USER_RETENTION;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'Boogi But Not Woogi?!';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/retention', $data);
        }

        return $email->send();
    }

    public static function sendRetention14Email($data)
    {
        $data['template_id'] = MCMDBridge::USER_RETENTION_REPLY;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
        $email->subject = 'No Boogi, no Show';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/retention14', $data);
        }

        return $email->send();
    }

    private static function _compileGigContent($gigs)
    {
        $html = '';
        foreach ($gigs as $gig) {
            foreach ($gig as $item) {
                // Add section header
                if ($item === reset($gig)) {
                    $html .= '<p style="text-align: left;"><a href="' . Yii::app()->params['baseUrl'] . '/gig/' .  $item['gig_alias'] . '"><strong>' . $item['gig_name'] . '</strong></a>';
                    $html .= ' with following artist(s): ';
                }

                // Compile body
                $html .= '<a href="' . Yii::app()->params['baseUrl'] . '/' .  $item['artist_alias'] . '">' . $item['artist_name'] . '</a>';

                // Close section or add comma
                if ($item === end($gig)) {
                    $html .= '</p>';
                } else {
                    $html .= ', ';
                }
            }
        }
        return $html;
    }

    public static function sendGigInRadiusEmail($data)
    {
//        $data['content'] = self::_compileGigContent($data['gigs']);

        $data['template_id'] = MCMDBridge::PROMOTER_GIG_IN_RADIUS;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
//        $email->subject = $data['gig_count'] > 1 ? 'Check Artists Dates' : 'Check Artist Dates';
        $email->subject = 'Check Artist Dates';


        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/gig-in-radius', $data);
        }

        return $email->send();
    }

    public static function sendFollowedEmail($data)
    {
//        $data['content'] = self::_compileGigContent($data['gigs']);

        $data['template_id'] = MCMDBridge::PROMOTER_FOLLOWERS;
        $email = new Mailer($data);

        $email->from = Yii::app()->params['fromEmail'];
        $email->fromName = Yii::app()->params['fromName'];

        $email->to = $data['email'];
        $email->toName = $data['name'];
//        $email->subject = $data['gig_count'] > 1 ? 'Check Artists Dates' : 'Check Artist Dates';

        if ($email->delivery != Mailer::DELIVERY_MANDRILL) {
            $email->attachBehavior('emailRenderer', new EmailRenderer);
            $email->message = $email->render('/email/gig-in-radius', $data);
        }

        return $email->send();
    }

    public static function getMailOptions($email, $email_template_id)
    {
        $logs = Yii::app()->db->createCommand("
            SELECT *
            FROM mail_log
            WHERE email = '" . $email . "'
              AND email_template_id = " . (int)$email_template_id . ";"
        )->queryAll();

        $result = array();
        if (!empty($logs)) {
            foreach ( $logs as $log ) {
                $options = \CJSON::decode( $log['options'] );
                if (isset($options['options'])) {
                    foreach ( $options['options'] as $gig_id => $artists ) {
                        if ( isset( $result[ $gig_id ] ) ) {
                            $result[ $gig_id ] = array_unique( array_merge( $result[ $gig_id ], $artists ) );
                        } else {
                            $result[ $gig_id ] = array_unique( $artists );
                        }
                    }
                }
            }
        }

        return $result;
    }

    public static function log($email, $email_template_id, $options)
    {
        try {
            $email = Yii::app()->db->quoteValue($email);
            $options = Yii::app()->db->quoteValue(\CJSON::encode($options));
            return Yii::app()->db->createCommand("
                INSERT INTO mail_log (email, email_template_id, options)
                VALUES (" . $email . "," . $email_template_id . "," . $options . ");"
            )->execute();
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'email');
        }
        return 0;
    }
}