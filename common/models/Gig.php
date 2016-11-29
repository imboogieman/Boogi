<?php

/**
 * This is the model class for table "gig".
 *
 * The followings are the available columns in table 'gig':
 * @property integer $id
 * @property integer $user_id
 * @property integer $venue_id
 * @property string $name
 * @property string $description
 * @property string $alias
 * @property string $datetime_from
 * @property string $datetime_to
 * @property string $timezone
 * @property string $address
 * @property integer $price
 * @property integer $currency
 * @property integer $capacity
 * @property integer $type
 * @property string $ds_id
 * @property integer $ds_type
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Venue $venue
 * @property ArtistGig[] $artistGigs
 * @property GigFile[] $gigFiles
 * @property Message[] $messages
 *
 * @TODO: Decrease Overall complexity
 * @TODO: Replace $_REQUEST global variable
 */
class Gig extends Model
{
    public $image;

    protected $_related_params = array(
        'artist_id' => null
    );

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'gig';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('venue_id, price, datetime_from, datetime_to', 'required'),
            array('user_id, venue_id, capacity, type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('description, timestamp', 'safe'),
            array('name, datetime_from, datetime_to, timestamp', 'safe', 'on' => 'search'),
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
                'field'     => 'gig_datetime',
                'message'   => 'Selected date in the past'
            );
        }

        if ($this->datetime_from > $this->datetime_to) {
            $result['result'] = ApiStatus::INVALID;
            $result['errors'][] = array(
                'field'     => 'gig_datetime',
                'message'   => 'Please check gig dates'
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'venue' => array(self::BELONGS_TO, 'Venue', 'venue_id'),
            'artistGigs' => array(self::HAS_MANY, 'ArtistGig', 'gig_id'),
            'gigFiles' => array(self::HAS_MANY, 'GigFile', 'gig_id'),
            'messages' => array(self::HAS_MANY, 'Message', 'gig_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => 'ID',
            'user_id'       => 'User',
            'venue_id'      => 'Venue',
            'name'          => 'Gig Name',
            'address'       => 'Address',
            'description'   => 'Description',
            'datetime_from' => 'Date From',
            'datetime_to'   => 'Date To',
            'timestamp'     => 'Timestamp',
            'capacity'      => 'Capacity',
            'type'          => 'Type',
            'ds_id'         => 'Data Provider ID',
            'ds_type'       => 'Data Provider',
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
        $criteria = new CDbCriteria;

        if (isset($_REQUEST['Gig']) && isset($_REQUEST['Gig']['venue']) && !empty($_REQUEST['Gig']['venue'])) {
            $venues = Venue::model()->findAll('name LIKE :name', array(
                ':name' => '%' . $_REQUEST['Gig']['venue'] . '%'
            ));
            if ($venues) {
                foreach ($venues as $venue) {
                    $criteria->compare('venue_id', $venue->id, false, 'OR');
                }
            }
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('datetime_from', $this->datetime_from, true);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria'      => $criteria,
            'pagination'    => array(
                'pageSize'  => 30,
            ),
        ));
    }

    /**
     * Save current gig data and update artist relations
     * @param boolean $runValidation whether to perform validation before saving the record.
     * If the validation fails, the record will not be saved to database.
     * @param array $attributes list of attributes that need to be saved. Defaults to null,
     * meaning all attributes that are loaded from DB will be saved.
     * @return boolean whether the saving succeeds
     */
    public function save($runValidation = true, $attributes = null)
    {
        if (parent::save($runValidation, $attributes)) {
            // Add new relations with gigs
            if (is_array($this->_related_params['artist_id'])) {
                // Delete all old relations with gigs
                ArtistGig::model()->deleteAll('gig_id = ?', array($this->id));

                // Add new records
                foreach ($this->_related_params['artist_id'] as $artist_id) {
                    $artistGig = new ArtistGig;
                    $artistGig->artist_id = $artist_id;
                    $artistGig->gig_id = $this->id;
                    $artistGig->save();
                }
            }

            // Generates alias
            $this->generateAlias();
            return true;
        }
        return false;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Artist the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Return venue frontend link
     * @return string
     */
    public function getArtists()
    {
        $result = array();
        foreach ($this->artistGigs as $artistGig) {
            $result[] = $artistGig->artist->getNormalizedData();
        }
        return $result;
    }

    /**
     * Return selection options array for CHtml::listBox
     * @return array
     */
    public function getArtistsSelected()
    {
        $result = array();
        foreach ($this->artistGigs as $artistGig) {
            $result[$artistGig->artist_id] = array('selected' => 'selected');
        }
        return $result;
    }

    /**
     * Get gigs assoc array
     * @return array
     */
    public static function getArray()
    {
        return CHtml::listData(Gig::model('Gig')->findAll(), 'id', 'name');
    }

    /**
     * Get gigs DS Ids
     * @param int $dataSource
     * @return array
     */
    public static function getDSIds($dataSource)
    {
        $result = array();
        $gigs = self::model()->findAll('ds_type = :ds_type', array(':ds_type' => $dataSource));
        foreach ($gigs as $gig) {
            $result[] = $gig->ds_id;
        }
        return $result;
    }

    /**
     * Gig types
     * @return array
     */
    public static function getTypes()
    {
        return array(
            1 => 'Club night',
            2 => 'Festival',
            3 => 'Solo concert',
            4 => 'Group concert',
            5 => 'Private party',
            6 => 'Wedding',
            7 => 'Corporate event',
            8 => 'Charity event',
            9 => 'College Or University',
            10 => 'Convention Or Tradeshow',
            11 => 'Endorsement Project'
        );
    }

    /**
     * Get readable type
     * @return string
     */
    public function getType()
    {
        $variants = self::getTypes();
        return isset($variants[$this->type]) ? $variants[$this->type] : 'Not set';
    }

    /**
     * Get readable capacity
     * @param int $id
     * @return string
     */
    public static function getTypeById($id)
    {
        $variants = self::getTypes();
        return isset($variants[$id]) ? $variants[$id] : 'Not set';
    }

    /**
     * Get readable data provide
     * @return string
     */
    public function getDataProvider()
    {
        $data = DataSource::getName($this->ds_type);
        return $data ? $data : 'Boogi';
    }

    /**
     * Gig all attributes lists
     * @return array
     */
    public static function getAttributesList()
    {
        return array(
            'types'          => Model::arrayToList(self::getTypes()),
            'accommodations' => Model::arrayToList(ArtistGig::getAccommodations()),
            'transfertypes'  => Model::arrayToList(ArtistGig::getTransferTypes()),
            'currencies'     => Model::arrayToList(Currency::getCurrencies()),
        );
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
     * Return formatted date
     * @param string $format
     * @return string
     */
    public function getDate($format = 'D, d M Y')
    {
        return date($format, strtotime($this->datetime_from));
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
            'name'          => $this->name,
            'alias'         => $this->alias,
            'link'          => $this->getLink(),
            'date'          => $this->getDate(),
        );

        if ($required) {
            $data['label']          = date('d.m', strtotime($this->datetime_from));
            $data['user_id']        = $this->user_id;
            $data['description']    = $this->description;
            $data['venue']          = $this->venue->getNormalizedData($follow);
            $data['promoter']       = $this->getPromoter();
            $data['provider']       = $this->getDataProvider();
            $data['image']          = $this->getMainImage();
            $data['capacity']       = $this->capacity;
            $data['type']           = $this->getType();
        }

        if ($follow) {
            $data['artists']        = $this->getArtists();
        }

        return $data;
    }

    /**
     * Return venue frontend link
     * @return string
     */
    public function getLink()
    {
        return '/gig/' . $this->alias;
    }


    /**
     * Return venue frontend link
     * @param int $user_role (optional) default ROLE_PROMOTER
     * @return string
     */
    public function getBookingLink($user_role = User::ROLE_PROMOTER)
    {
        $link = '/bookings/' . $this->id;
        return $user_role != User::ROLE_PROMOTER ? '/promoter' . $link : '/artist' . $link;
    }


    /**
     * Get gig promoter
     * @return Promoter
     */
    public function getPromoter()
    {
        $promoter = null;
        if ($this->user_id) {
            $promoter = Promoter::model()->find('user_id = :user_id', array(
                ':user_id' => $this->user_id
            ));
        }
        return $promoter ? $promoter->getNormalizedData() : null;
    }

    /**
     * Remove old imported gigs
     * @param array $excludeDSIds
     * @param int $dataSource
     * @return int
     */
    public static function clean($excludeDSIds, $dataSource)
    {
        // Delete gigs
        $criteria = new CDbCriteria();
        if (count($excludeDSIds)) {
            $criteria->addNotInCondition('ds_id', $excludeDSIds);
        }
        $criteria->addCondition('ds_type = ' . $dataSource);
        $criteria->addCondition('datetime_from >= CURDATE()');

        return Gig::model()->deleteAll($criteria);
    }

    /**
     * Return gig list
     * @param array $options
     * @return array
     */
    public static function getList($options = array())
    {
        // Check filters
        $criteria = new CDbCriteria();
        if (isset($options['from_date'])) {
            $criteria->addCondition("datetime_from >= '" . $options['from_date'] . "'");
        }
        if (isset($options['to_date'])) {
            $criteria->addCondition("datetime_to <= '" . $options['to_date'] . "'");
        }

        // Get list
        $result = array();
        $gigs = self::model()->cache(1000, Model::getCacheDependency('gig_list'))
            ->with('venue')->list()->findAll($criteria);

        if ($gigs) {
            foreach ($gigs as $gig) {
                $result[] = $gig->getNormalizedData();
            }
        }

        return $result;
    }


    /**
     * Get messages
     * @param int $artist_id
     * @return string
     */
    public function getMessagesByArtist($artist_id)
    {
        $result = array();
        foreach ($this->messages as $message) {
            if ($message->artist_id == $artist_id) {
                $result[] = $message->getNormalizedData();
            }
        }
        return $result;
    }

    /**
     * Return Gig booking item data
     * @return array
     */
    public function getBookingItemData()
    {
        $data = array(
            'id'            => $this->id,
            'date'          => $this->getDate('Y-m-d'),
            'name'          => $this->name,
            'venue'         => $this->venue->getNormalizedData(true),
            'capacity'      => $this->capacity,
            'type'          => $this->getType(),
            'description'   => $this->description,
            'artists'       => $this->getBookingArtists(),
        );

        return $data;
    }

    /**
     * Return Gig booking item artists
     * @return array
     */
    public function getBookingArtists()
    {
        $result = array();
        if ($this->artistGigs) {
            foreach($this->artistGigs as $item) {
                $result[] = array(
                    'gig_id'        => $item->gig_id,
                    'artist_id'     => $item->artist_id,
                    'status'        => $item->status == ArtistGig::STATUS_ACCEPTED ? 1 : 0,
                    'name'          => $item->artist->name,
                    'price'         => $item->price,
                    'currency'      => $item->getCurrency(),
                    'accommodation' => $item->getAccommodation(),
                    'transfertype'  => $item->getTransferType(),
                    'messages'      => $this->getMessagesByArtist($item->artist_id),
                );
            }
        }

        return $result;
    }

    /**
     * Return Gig booking form data
     * @return array
     */
    public function getBookingFormData()
    {
        $data = array(
            'id'            => $this->id,
            'date'          => $this->datetime_from,
            'venue_id'      => $this->venue->id,
            'venue'         => $this->venue->getFullName(),
            'description'   => $this->description,
            'capacity_id'   => $this->capacity,
            'type_id'       => $this->type,
        );

        return $data;
    }
}
