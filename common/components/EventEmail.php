<?php

/**
 * Email mixin class for Event
 * @property integer $email_status
 * @property integer $email_attempts
 */
class EventEmail extends CComponent
{
    const MAX_SEND_ATTEMPTS = 3;

    /**
     * @var string
     */
    public $layout = 'email';

    /**
     * @var Event
     */
    private $_event;

    /**
     * @var array
     */
    private $_eventData;

    /**
     * @var Mailer
     */
    private $_email;

    /**
     * @var Mailer
     */
    private $_template;

    /**
     * @var Event
     */
    private $_data;

    /**
     * @var array
     */
    private $_merged = array();

    /**
     * Constructor
     * @option Event $event
     */
    public function __construct($event)
    {
        // Attach email renderer
        $this->attachBehavior('emailRenderer', new EmailRenderer);

        // Check merged events
        if (!isset($event['is_merged'])) {
            $this->_init_single($event);
        } else {
            $this->_init_multi($event);
        }
    }

    /**
     * Single event initialisation
     * @option Event $event
     * @TODO: Decrease Cyclomatic complexity
     * @TODO: Decrease the number of lines
     */
    protected function _init_single($event)
    {
        // Set Event model
        $this->_event = $event;
        $this->_eventData = $event->getNormalizedData();

        // Set Email instance
        $this->_email = Yii::app()->email;
        $this->_email->from = Yii::app()->params['fromEmail'];
        $this->_email->fromName = Yii::app()->params['fromName'];

        // Init data
        switch ($this->_event->type) {
            case Event::BOOKING_UPDATE:
                $this->_email->to = $this->_eventData['init']['email'];
                $this->_email->toName = $this->_eventData['init']['name'];
                $this->_email->subject = 'You have an update on your booking';

                $this->_template = '/email/booking-update';
                $this->_data = array(
                    'promoter'  => $this->_eventData['init']['name'],
                    'gig'       => $this->_eventData['target']['name'],
                    'link'      => $this->_eventData['target']['link'],
                    'date'      => $this->_eventData['target']['date']
                );
                break;
            case Event::BOOKING_CREATE:
                $this->_email->to = $this->_eventData['init']['email'];
                $this->_email->toName = $this->_eventData['init']['name'];
                $this->_email->subject = $this->_eventData['creator']['name'] . ' has confirmed a new gig';

                $this->_template = '/email/booking-create';
                $this->_data = array(
                    'promoter'  => $this->_eventData['init']['name'],
                    'artist'    => $this->_eventData['creator']['name'],
                    'link'      => $this->_eventData['creator']['link'],
                    'date'      => $this->_eventData['target']['date'],
                    'gig_link'  => $this->_eventData['target']['link'],
                    'gig'       => $this->_eventData['target']['name']
                );
                break;
            case Event::BOOKING_TRACK:
                $promoter = Promoter::model()->find('user_id = :user_id', array(
                    ':user_id' => $this->_eventData['target']['user_id']
                ));

                $this->_email->to = $this->_eventData['init']['email'];
                $this->_email->toName = $this->_eventData['init']['name'];
                $this->_email->subject = $promoter->name . ' has made a new booking';

                $this->_template = '/email/booking-track';
                $this->_data = array(
                    'promoter'      => $this->_eventData['init']['name'],
                    'artist'        => $this->_eventData['target']['name'],
                    'link'          => $this->_eventData['target']['link'],
                    'follow'        => $promoter->name,
                    'follow_link'   => $promoter->getLink()
                );
                break;
            // @TODO: Add cascade notifications
            case Event::FOLLOW_ARTIST:
            case Event::FOLLOW_PROMOTER:
                $this->_email->to = Yii::app()->params['adminEmail'];
                $this->_email->toName = Yii::app()->params['adminName'];
                $this->_email->subject = $this->_eventData['init']['name'] . ' is now following ' . $this->_eventData['target']['name'];

                $this->_template = '/email/follow';
                $this->_data = array(
                    'promoter'      => 'Admin',
                    'follow'        => $this->_eventData['init']['name'],
                    'follow_link'   => $this->_eventData['init']['link'],
                    'target'        => $this->_eventData['target']['name'],
                    'target_link'   => $this->_eventData['target']['link']
                );
                break;
            // @TODO: Add cascade notifications
            case Event::UNFOLLOW_ARTIST:
            case Event::UNFOLLOW_PROMOTER:
                $this->_email->to = Yii::app()->params['adminEmail'];
                $this->_email->toName = Yii::app()->params['adminName'];
                $this->_email->subject = $this->_eventData['init']['name'] . ' is now not following ' . $this->_eventData['target']['name'];

                $this->_template = '/email/unfollow';
                $this->_data = array(
                    'promoter'      => 'Admin',
                    'follow'        => $this->_eventData['init']['name'],
                    'follow_link'   => $this->_eventData['init']['link'],
                    'target'        => $this->_eventData['target']['name'],
                    'target_link'   => $this->_eventData['target']['link']
                );
                break;
            // @TODO: Add cascade notifications
            case Event::ARTIST_CREATE:
                $this->_email->to = Yii::app()->params['adminEmail'];
                $this->_email->toName = Yii::app()->params['adminName'];
                $this->_email->subject = $this->_eventData['target']['name'] . ' is in the game';

                $this->_template = '/email/artist-create';
                $this->_data = array(
                    'promoter'  => $this->_eventData['init']['name'],
                    'name'      => $this->_eventData['target']['name'],
                    'link'      => $this->_eventData['target']['link']
                );
                break;
            case Event::ARTIST_TRACK:
                $this->_email->to = $this->_eventData['creator']['email'];
                $this->_email->toName = $this->_eventData['creator']['name'];
                $this->_email->subject = $this->_eventData['init']['name'] . ' added a new gig';

                $this->_template = '/email/artist-track';
                $this->_data = array(
                    'promoter'  => $this->_eventData['creator']['name'],
                    'artist'    => $this->_eventData['init']['name'],
                    'link'      => $this->_eventData['init']['link'],
                    'gig'       => $this->_eventData['target']['name'],
                    'gig_link'  => $this->_eventData['target']['link']
                );
                break;
            // @TODO: Add cascade notifications
            case Event::GIG_CREATE:
                $this->_email->to = Yii::app()->params['adminEmail'];
                $this->_email->toName = Yii::app()->params['adminName'];
                $this->_email->subject = 'Artist added a new gig';

                $this->_template = '/email/gig-create';
                $this->_data = array(
                    'promoter'  => 'Admin',
                    'name'      => $this->_eventData['init']['name'],
                    'gig'       => $this->_eventData['target']['name'],
                    'link'      => $this->_eventData['target']['link']
                );
                break;
            // @TODO: Add cascade notifications
            case Event::PROMOTER_CREATE:
                $this->_email->to = Yii::app()->params['adminEmail'];
                $this->_email->toName = Yii::app()->params['adminName'];
                $this->_email->subject = $this->_eventData['init']['name'] . ' is in the game';

                $this->_template = '/email/promoter-create';
                $this->_data = array(
                    'promoter'  => 'Admin',
                    'name'      => $this->_eventData['init']['name'],
                    'link'      => $this->_eventData['init']['link'],
                );
                break;
        }

        // Check debug mode
        if (Yii::app()->params['isDebug']) {
            $this->_email->to = Yii::app()->params['adminEmail'];
            $this->_email->toName = Yii::app()->params['adminName'];
        }

        // Render message body
        $this->_email->message = $this->render($this->_template, $this->_data);
    }

    /**
     * Merged events initialisation
     * @option array $data
     */
    protected function _init_multi($data)
    {
        if (isset($data['events']) && count($data['events'])) {
            // Set Event model
            $this->_event = reset($data['events']);
            $this->_eventData = $this->_event->getNormalizedData();

            // Set Email instance
            $this->_email = Yii::app()->email;
            $this->_email->from = Yii::app()->params['fromEmail'];
            $this->_email->fromName = Yii::app()->params['fromName'];

            // Init data
            $this->_email->to = $this->_eventData['init']['email'];
            $this->_email->toName = $this->_eventData['init']['name'];
            $this->_email->subject = 'New gigs from your artists';

            // Generate email from events
            $body = '';
            foreach ($data['events'] as $event) {
                $this->_merged[] = $event->id;
                $data = array(
                    'artist'        => $event->init_name,
                    'artist_link'   => '/' . $event->init_link,
                    'gig'           => $event->target_name,
                    'gig_link'      => '/' . $event->target_link
                );
                $body .= $this->renderPartial('/email/daily-item', $data);
            }

            // Compile email template
            $this->_template = '/email/daily-updates';
            $this->_data = array(
                'promoter'  => $this->_event->type == Event::ARTIST_TRACK ? $this->_eventData['creator']['name'] : 'Admin',
                'title'     => 'Your followed artists added ' . count($this->_merged) . ' new gig(s).',
                'body'      => $body
            );

            // Check debug mode
            if (Yii::app()->params['isDebug']) {
                $this->_email->to = Yii::app()->params['adminEmail'];
                $this->_email->toName = Yii::app()->params['adminName'];
            }

            // Render message body
            $this->_email->message = $this->render($this->_template, $this->_data);
        }
    }

    /**
     * Get message data
     * @return bool
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Get Email from
     * @return bool
     */
    public function getFrom()
    {
        return $this->_email->from;
    }

    /**
     * Set Email from
     * @param string $from
     * @return bool
     */
    public function setFrom($from)
    {
        return $this->_email->from = $from;
    }

    /**
     * Get Email to
     * @return bool
     */
    public function getTo()
    {
        return $this->_email->to;
    }

    /**
     * Set Email to
     * @param string $email
     * @return bool
     */
    public function setTo($email)
    {
        return $this->_email->to = $email;
    }

    /**
     * Get Email subject
     * @return bool
     */
    public function getSubject()
    {
        return $this->_email->subject;
    }

    /**
     * Get Email body
     * @return bool
     */
    public function getMessage()
    {
        return $this->_email->message;
    }

    /**
     * Get template
     * @return bool
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Send Email
     * @return bool
     */
    public function send()
    {
        if ($this->_event && $this->_event->email_attempts < Event::EMAIL_MAX_SEND_ATTEMPTS) {
            if ($this->_email->send()) {
                $this->_event->email_status = Event::EMAIL_SENT;
            } else {
                $this->_event->email_status = Event::EMAIL_NOT_SENT;
                $this->_event->email_attempts += 1;
            }

            // Update and return result
            if (count($this->_merged)) {
                return ($this->_event->email_status = Event::EMAIL_SENT) && Yii::app()->db->createCommand("
                    UPDATE event
                    SET email_status = " . $this->_event->email_status . ",
                        email_attempts = " . $this->_event->email_attempts . "
                    WHERE id IN (" . implode(',', $this->_merged) . ");
                ")->execute();
            } else {
                return ($this->_event->email_status = Event::EMAIL_SENT) && $this->_event->save();
            }
        } else {
            $this->_event->email_status = Event::EMAIL_ERROR;
            $this->_event->save();

            return false;
        }
    }

    public static function getDummyMessage($type)
    {
        $data = Event::getDummyData($type);
        $renderer = new EmailRenderer;
        return $renderer->render($data['template'], $data);
    }
}