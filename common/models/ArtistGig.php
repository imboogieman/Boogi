<?php

/**
 * This is the model class for table "artist_gig".
 *
 * The followings are the available columns in table 'artist_gig':
 * @property integer $id
 * @property integer $artist_id
 * @property integer $gig_id
 * @property string $datetime_from
 * @property string $datetime_to
 * @property string $timezone
 * @property string $address
 * @property integer $price
 * @property integer $currency
 * @property integer $revenue_share
 * @property integer $status
 * @property integer $accommodation
 * @property integer $transfer
 * @property string $start_time
 * @property string $end_time
 * @property integer $next_day
 * @property integer $last_changed
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Gig $gig
 * @property Artist $artist
 *
 * @TODO: Decrease Overall complexity
 */
class ArtistGig extends Model
{
    const STATUS_OPEN = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_ADJUSTED_BY_PROMOTER = 3;
    const STATUS_ADJUSTED_BY_ARTIST = 4;
    const STATUS_REJECTED = 5;
    const STATUS_HIDDEN = 6;

    const ACTION_EDIT = 100;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'artist_gig';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('artist_id, gig_id, price, datetime_from, datetime_to', 'required'),
            array('id, artist_id, gig_id, currency, status, accommodation, transfer', 'numerical', 'integerOnly' => true),
            array('datetime_from, datetime_to, timestamp', 'safe'),
            array('id, artist_id, gig_id, timestamp', 'safe', 'on' => 'search'),
        );
    }

    public function validateFields()
    {
        $result = array(
            'result'    => ApiStatus::SUCCESS,
            'errors'    => array(),
            'message'   => 'Please fix errors bellow and try again'
        );

        if ($this->datetime_from <= date('Y-m-d')) {
            $result['result'] = ApiStatus::INVALID;
            $result['errors'][] = array(
                'field'     => 'book_datetime',
                'message'   => 'Selected date in the past'
            );
        }

        if ($this->datetime_from > $this->datetime_to) {
            $result['result'] = ApiStatus::INVALID;
            $result['errors'][] = array(
                'field'     => 'book_datetime',
                'message'   => 'Please check booking dates'
            );
        }

        return $result;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gig' => array(self::BELONGS_TO, 'Gig', 'gig_id'),
            'artist' => array(self::BELONGS_TO, 'Artist', 'artist_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'artist_id' => 'Artist',
            'gig_id' => 'Gig',
            'status' => 'Status',
            'price' => 'Fee offer',
            'currency' => 'Currency',
            'timestamp' => 'Timestamp',
            'accommodation' => 'Accommodation',
            'transfer' => 'Transfer',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('artist_id', $this->artist_id);
        $criteria->compare('gig_id', $this->gig_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Promoter the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Get readable currency array
     * @return string
     */
    public function getCurrency()
    {
        return Currency::getCurrencyById($this->currency);
    }

    /**
     * Get readable currency array
     * @return string
     */
    public function getCurrencySymbol()
    {
        return Currency::getCurrencySymbolById($this->currency);
    }


    /**
     * Return all statuses array
     * @param bool $is_promoter (optional), default True
     * @return array
     */
    public static function getStatuses($is_promoter = true)
    {
        $statuses = array(
            self::STATUS_OPEN                   => 'Open',
            self::STATUS_ADJUSTED_BY_PROMOTER   => 'Open with event',
            self::STATUS_ADJUSTED_BY_ARTIST     => 'Open with event',
            self::STATUS_ACCEPTED               => 'Accepted',
            self::STATUS_CONFIRMED              => 'Confirmed',
            self::STATUS_REJECTED               => 'Rejected',
            self::ACTION_EDIT                   => 'Edit'
        );

        if ($is_promoter) {
            // #80334574
            $statuses[self::STATUS_REJECTED] = 'Closed';
        }

        return $statuses;
    }

    /**
     * Return all statuses list
     * @return array
     */
    public static function getStatusesList()
    {
        return Model::arrayToList(self::getStatuses());
    }

    /**
     * Return allowed status array for current booking
     * @param $current_status - current booking status
     * @param bool $is_promoter (optional), default True
     * @return array
     * @TODO: Decrease Cyclomatic complexity
     */
    public static function getAvailableStatusList($current_status, $is_promoter = true)
    {
        $statuses = self::getStatuses();

        // Always hide adjusted status (will be set automatically)
        unset($statuses[self::STATUS_ADJUSTED_BY_PROMOTER]);
        unset($statuses[self::STATUS_ADJUSTED_BY_ARTIST]);

        if ($is_promoter) {
            // Always hide accepted status for promoter
            unset($statuses[self::STATUS_ACCEPTED]);

            switch($current_status) {
                case self::STATUS_OPEN:
                    unset($statuses[self::STATUS_CONFIRMED]);
                    break;
                case self::STATUS_ADJUSTED_BY_PROMOTER:
                    unset($statuses[self::STATUS_OPEN]);
                    unset($statuses[self::STATUS_CONFIRMED]);
                    break;
                case self::STATUS_ADJUSTED_BY_ARTIST:
                    unset($statuses[self::STATUS_OPEN]);
                    break;
                case self::STATUS_ACCEPTED:
                    unset($statuses[self::STATUS_OPEN]);
                    break;
                case self::STATUS_CONFIRMED:
                    unset($statuses[self::STATUS_OPEN]);
                    break;
                case self::STATUS_REJECTED:
                    unset($statuses[self::STATUS_OPEN]);
                    unset($statuses[self::STATUS_CONFIRMED]);
                    break;
            }
        } else {
            // Always hide confirmed status for artist
            unset($statuses[self::STATUS_CONFIRMED]);

            switch($current_status) {
                case self::STATUS_OPEN:
                    break;
                case self::STATUS_ADJUSTED_BY_PROMOTER:
                    unset($statuses[self::STATUS_OPEN]);
                    break;
                case self::STATUS_ADJUSTED_BY_ARTIST:
                    unset($statuses[self::STATUS_OPEN]);
                    unset($statuses[self::STATUS_ACCEPTED]);
                    break;
                case self::STATUS_ACCEPTED:
                    unset($statuses[self::STATUS_OPEN]);
                    break;
                case self::STATUS_CONFIRMED:
                    unset($statuses[self::STATUS_OPEN]);
                    unset($statuses[self::STATUS_ACCEPTED]);
                    break;
                case self::STATUS_REJECTED:
                    unset($statuses[self::STATUS_OPEN]);
                    unset($statuses[self::STATUS_ACCEPTED]);
                    break;
            }
        }

        return self::getStatusForButtons($statuses);
    }

    /**
     * Return list of allowed statuses
     * @param $statuses - allowed statuses
     * @param bool $is_promoter (optional), default True
     * @return array
     */
    public static function getStatusForButtons($statuses, $is_promoter = true)
    {
        foreach ($statuses as $id => &$status) {
            switch($id) {
                case self::STATUS_ACCEPTED:
                    $status = 'Accept';
                    break;
                case self::STATUS_CONFIRMED:
                    $status = 'Confirm';
                    break;
                case self::STATUS_REJECTED:
                    if ($is_promoter) {
                        $status = 'Cancel Booking';
                    } else {
                        $status = 'Reject';
                    }
                    break;
            }
        }

        // Append edit button and sort statuses
        $statuses[self::ACTION_EDIT] = 'Edit Booking';
        $statuses = Model::arrayToList($statuses);
        usort($statuses, array('ArtistGig', 'sortStatuses'));

        return $statuses;
    }

    public static function sortStatuses($a, $b)
    {
        $x = $a['id'];
        $y = $b['id'];

        $super_statuses = array(self::STATUS_ACCEPTED, self::STATUS_CONFIRMED);
        if (in_array($x, $super_statuses)) {
            $x += 100;
        }
        if (in_array($y, $super_statuses)) {
            $y += 100;
        }

        if ($x == $y) {
            return 0;
        }
        return ($x < $y) ? 1 : -1;
    }

    /**
     * Get readable status
     * @return string
     */
    public function getStatus()
    {
        $variants = self::getStatuses();
        return isset($variants[$this->status]) ? $variants[$this->status] : 'Not set';
    }

    /**
     * Get readable status by id
     * @param int $id
     * @return string
     */
    public static function getStatusById($id)
    {
        $variants = self::getStatuses();
        return isset($variants[$id]) ? $variants[$id] : 'Not set';
    }

    /**
     * Gig accommodations
     * @return array
     */
    public static function getAccommodations()
    {
        return array(
            1 => 'No/Yourself',
            2 => 'Couch',
            3 => 'Hostel',
            4 => 'Rented flat',
            5 => '1 star hotel',
            6 => '2 star hotel',
            7 => '3 star hotel',
            8 => 'VIP'
        );
    }

    /**
     * Get readable accommodation
     * @return string
     */
    public function getAccommodation()
    {
        $variants = self::getAccommodations();
        return isset($variants[$this->accommodation]) ? $variants[$this->accommodation] : 'Not set';
    }

    /**
     * Get readable accommodation by id
     * @param int $id
     * @return string
     */
    public static function getAccommodationById($id)
    {
        $variants = self::getAccommodations();
        return isset($variants[$id]) ? $variants[$id] : 'Not set';
    }

    /**
     * Gig accommodations
     * @return array
     */
    public static function getTransferTypes()
    {
        return array(
            1 => 'No/Yourself',
            2 => 'Car',
            3 => 'Bus',
            4 => 'Coach',
            5 => 'Plane',
            6 => 'Private Air Transportation'
        );
    }

    /**
     * Get readable transfer type
     * @return string
     */
    public function getTransferType()
    {
        $variants = self::getTransferTypes();
        return isset($variants[$this->transfer]) ? $variants[$this->transfer] : 'Not set';
    }

    /**
     * Get readable transfer type by id
     * @param int $id
     * @return string
     */
    public static function getTransferTypeById($id)
    {
        $variants = self::getTransferTypes();
        return isset($variants[$id]) ? $variants[$id] : 'Not set';
    }

    /**
     * Return Gig normalized data
     * @param bool $required
     * @param bool $follow
     * @return array
     */
    public function getNormalizedData($required = true, $follow = false)
    {
        $data = array(
            'id'            => $this->id,
            'artist_id'     => $this->artist_id,
            'gig_ig'        => $this->gig_ig,
            'status'        => $this->status == self::STATUS_ACCEPTED ? 1 : 0,
        );

        if ($required) {
            $data['price']          = $this->price;
            $data['currency']       = $this->getCurrency();
            $data['accommodation']  = $this->getAccommodation();
            $data['transfertype']   = $this->getTransferType();
            $data['artist']         = $this->artist->getNormalizedData($follow);
            $data['gig']            = $this->gig->getNormalizedData($follow);
        }

        return $data;
    }

    public function getBookingItemData()
    {
        $promoter = $this->gig->getPromoter();
        $data = array(
            'gig_id'        => $this->gig_id,
            'artist_id'     => $this->artist_id,
            'date'          => $this->gig->getDate(),
            'name'          => $this->gig->name,
            'venue'         => $this->gig->venue->getNormalizedData(true),
            'promoter'      => !empty($promoter) ? $promoter['name'] : '',
            'price'         => $this->price,
            'currency'      => $this->getCurrency(),
            'description'   => $this->gig->description,
            'artists'       => $this->getBookingArtists(),
            'type'          => $this->gig->getType(),
            'capacity'      => $this->gig->getCapacity(),
            'accommodation' => $this->getAccommodation(),
            'transfertype'  => $this->getTransferType(),
        );

        return $data;
    }

    /**
     * Return Gig booking item artists
     * @return array
     */
    public function getBookingArtists()
    {
        $artistGigs = ArtistGig::model()->cache(1000, Model::getCacheDependency('artist_gig'))
            ->findAll('gig_id = :gig_id', array(':gig_id' => $this->gig_id));

        $result = array();
        if ($artistGigs) {
            foreach($artistGigs as $item) {
                $result[] = array(
                    'name'  => $item->artist->name,
                    'link'  => $item->artist->getLink()
                );
            }
        }

        return $result;
    }

    /**
     * Return artist frontend link
     * @param int $user_role (optional) default ROLE_PROMOTER
     * @return string
     */
    public function getLink($user_role = User::ROLE_PROMOTER)
    {
        $link = '/bookings/' . $this->gig_id . '-' . $this->artist_id;
        return $user_role != User::ROLE_PROMOTER ? '/promoter' . $link : '/artist' . $link;
    }
}
