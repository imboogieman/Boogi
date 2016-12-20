<?php

/**
 * This is the model class for table "promoter".
 *
 * The followings are the available columns in table 'promoter':
 * @property integer $id
 * @property integer $user_id
 * @property integer $is_approved
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property string $timestamp
 * @property string $latitude
 * @property string $longitude
 * @property string $radius
 * @property string $address
 * @property string $facebook
 * @property string $twitter
 * @property string $homepage
 * @property int $fb_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property PromoterFile[] $promoterFiles
 * @property ArtistPromoter[] $promoterArtists
 * @property PromoterPromoter[] $promoterPromoters
 *
 * @TODO: Consider refactoring to keep number of methods under 10
 * @TODO: Decrease Overall complexity
 */
class Promoter extends Model
{
    public $image;

    protected $_related_params = array(
        'email'     => null,
        'password'  => null,
        'role'      => null,
        'create_date' => null,
        'c_name'      => null,
        'category'  => null,
        'c_address'   => null,
        'founding_date' => null,
        'phone' => null,
        'website' => null,
        'description' => null
    );

    public function scopes()
    {
        return array(
            'list' => array(
                'order' => 't.timestamp DESC',
                'limit' => 30,
            )
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'promoter';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, name', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('description, timestamp', 'safe'),
            array('radius, latitude, longitude', 'numerical'),
            array('is_approved, fb_id', 'numerical', 'integerOnly' => true),
            array('fb_id', 'length', 'max' => 64),
            array('id, is_approved, name, latitude, longitude, radius, fb_id', 'safe', 'on' => 'search'),
            array('address', 'length', 'max' => 255),
            array('homepage', 'length', 'max' => 255),
            array('facebook', 'length', 'max' => 255),
            array('facebook_name', 'length', 'max' => 255),
            array('description', 'type', 'type'=>'string'),
            array('page', 'length', 'max' => 64),
            array('genres', 'length', 'max' => 256),
            array('experience', 'length', 'max' => 128),
            array('f_artists', 'length', 'max' => 256),
        );
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
            'promoterFiles' => array(self::HAS_MANY, 'PromoterFile', 'promoter_id'),
            'promoterArtists' => array(self::HAS_MANY, 'ArtistPromoter', 'promoter_id'),
            'promoterPromoters' => array(self::HAS_MANY, 'PromoterPromoter', 'promoter_id'),
            'companies' => array(self::HAS_ONE, 'Companies', 'company_id'),
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
            'is_approved'   => 'Approved',
            'name'          => 'Name',
            'description'   => 'Description',
            'timestamp'     => 'Timestamp',
            'latitude'      => 'Latitude',
            'longitude'     => 'Longitude',
            'radius'        => 'Radius',
            'fb_id'         => 'Facebook ID'
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('timestamp', $this->timestamp, true);
        $criteria->compare('latitude', $this->latitude);
        $criteria->compare('longitude', $this->longitude);
        $criteria->compare('radius', $this->radius);
        $criteria->compare('fb_id', $this->fb_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
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
     * Save action with related User creation
     * @param bool $runValidation
     * @param array $attributes
     * @return bool|void
     */
    public function save($runValidation = true, $attributes = null)
    {
        // Update related user params
        if ( isset( $this->_related_params['email'] ) && isset( $this->_related_params['password'] ) ) {
            if ( $this->user_id ) {
//                $this->user->email = $this->_related_params['email'];
//                $this->user->role  = User::ROLE_PROMOTER;
//
//                // Check password update
//                if ( $this->_related_params['password'] != '********' ) {
//                    $this->user->password = CPasswordHelper::hashPassword( $this->_related_params['password'] );
//                }
//
//                if ( ! $this->user->save() ) {
//                    foreach ( $this->user->getErrors() as $attribute => $error ) {
//                        foreach ( $error as $e ) {
//                            $this->addError( $attribute, $e );
//                        }
//                    }
//
//                    return false;
//                }
            } else {
                $user        = new User;
                $user->email = $this->_related_params['email'];
                $user->role  = User::ROLE_PROMOTER;

                // Check password update
                if ( $this->_related_params['password'] != '********' ) {
                    $user->password = CPasswordHelper::hashPassword( $this->_related_params['password'] );
                }

                if ( $user->save() ) {
                    $this->user = $user;
                    $this->setAttribute( 'user_id', $user->id );
                } else {
                    foreach ( $user->getErrors() as $attribute => $error ) {
                        foreach ( $error as $e ) {
                            $this->addError( $attribute, $e );
                        }
                    }

                    return false;
                }
            }
        }



        // Call parent save and generates alias
        if ( parent::save( $runValidation, $attributes ) ) {
            $this->generateAlias();
            if ( isset( $this->_related_params['c_name'] ) && $this->id ) {
                $company                = new Companies;
                $company->promoter_id   = $this->id;
                $company->name          = $this->_related_params['c_name'];
//                $company->category      = $this->_related_params['category'];
                $company->address       = $this->_related_params['c_address'];
                $company->founding_date = $this->_related_params['founding_date'];
                $company->phone         = $this->_related_params['phone'];
                $company->website       = $this->_related_params['website'];
                $company->description   = $this->_related_params['description'];

                if ( !$company->save( false ) ) {
                    foreach ( $company->getErrors() as $attribute => $error ) {
                        foreach ( $error as $e ) {
                            $this->addError( $attribute, $e );
                        }
                    }

                    return false;
                }
            }
            return true;
        } else {
            foreach ( parent::getErrors() as $attribute => $error ) {
                foreach ( $error as $e ) {
                    $this->addError( $attribute, $e );
                }
            }

            return false;
        }
    }

    /**
     * Return Promoter normalized data
     * @param bool $required
     * @return array
     */
    public function getNormalizedData($required = true)
    {
        $data = array(
            'id'            => $this->id,
            'name'          => $this->name,
            'link'          => $this->getLink(),
            'date'          => date('Y-m-d', strtotime($this->timestamp))
        );

        if ($required) {
            $data['user_id']        = $this->user_id;
            $data['is_approved']    = $this->is_approved ? 1 : 0;
            $data['email']          = $this->user ? $this->user->email : Yii::app()->params['adminEmail'];
            $data['alias']          = $this->alias;
            $data['description']    = $this->description;
            $data['latitude']       = $this->latitude;
            $data['longitude']      = $this->longitude;
            $data['radius']         = $this->radius;
            $data['address']        = $this->address;
            $data['facebook']       = $this->facebook;
            $data['twitter']        = $this->twitter;
            $data['homepage']       = $this->homepage;
            $data['image']          = $this->getMainImage();
            $data['crop']           = $this->getCropImage();
            $data['thumb']          = $this->getThumbImage();
            $data['following']      = $this->isCurrentUserFollowing();
        }

        return $data;
    }

    /**
     * Check if logged promoter follow current promoter
     * @return bool
     */
    public function isCurrentUserFollowing()
    {
        // Check command mode
        if (!Yii::app()->hasProperty('user')) return false;

        if (!Yii::app()->user->isGuest) {
            $promoter = Promoter::getLogged();
            if ($promoter->user->role == User::ROLE_PROMOTER) {
                foreach ($promoter->promoterPromoters as $promoterPromoter) {
                    if ($promoterPromoter->follow_id == $this->id) return true;
                }
            }
        }

        return false;
    }

    /**
     * Return Promoter list with normalized data
     * @return array
     */
    public static function getList()
    {
        // Get list
        $result = array();
        $promoters = self::model()->cache(1000, Model::getCacheDependency('promoter_list'))
            ->with('promoterPromoters')->list()->findAll();

        if ($promoters) {
            foreach ($promoters as $promoter) {
                $result[] = $promoter->getNormalizedData();
            }
        }

        return $result;
    }

    /**
     * Return Promoters dashboard data
     * @return array
     */
    public function getDashboardData()
    {
        // Compiled data
        $data = array(
            'events'    => $this->_getRawPromoterEventsForDashboard(),
            'artists'   => $this->_getRawFollowedArtistsForDashboard(),
            'promoters' => $this->_getRawFollowedPromotersForDashboard(),
            'bookings'  => $this->_getRawPromoterGigsForDashboard(),
        );

        return $data;
    }

    /**
     * Return logged promoter
     * @return Promoter $promoter
     */
    public static function getLogged()
    {
        if (php_sapi_name() == 'cli') {
            return false;
        }

        if ($user_id = Yii::app()->user->getId()) {
            return Promoter::model()->with('promoterPromoters','promoterArtists')
                ->find('user_id = :user_id', array(':user_id' => $user_id));
        }
    }

    /**
     * Return all promoter events
     * @param bool $required
     * @param int $self_promoter_id
     * @param bool $is_follow
     * @return Event[]
     */
    public function getEvents($required = false, $self_promoter_id = null, $is_follow = false)
    {
        $events = Event::model()->cache(1000, Model::getCacheDependency('event'))
            ->findAll("init_id = :init_id AND type <> :type", array(
                ':init_id' => $this->id,
                ':type'    => Event::GIG_CREATE
            ));

        $result = array();
        foreach ($events as $event) {
            $event_data = $event->getNormalizedData($required, false, $is_follow);
            if ($event_data['init'] && $event_data['target']) {
                // Check self message pointer
                if ($event->init_type == 'Promoter' && $event->init_id == $self_promoter_id) {
                    $event_data['init']['name'] = 'You';
                }
                if ($event->target_type == 'Promoter' && $event->target_id == $self_promoter_id) {
                    $event_data['target']['name'] = 'You';
                }

                $result[] = $event_data;
            }
        }

        return $result;
    }

    /**
     * Return promoter frontend link
     * @return string
     */
    public function getLink()
    {
        return '/promoter/' . $this->alias;
    }

    /**
     * Create cascade promoter events
     * @param int $type
     * @param Model $target
     */
    public function createCascadeEvents($type, $target)
    {
        switch ($type) {
            // $target = Gig
            case Event::BOOKING_UPDATE:
                foreach ($target->artistGigs as $artistGig) {
                    // Notify all promoters who follow current promoter
                    foreach ($this->promoterPromoters as $promoterPromoter) {
                        $promoterPromoter->promoter->getOrCreateEvent(Event::BOOKING_TRACK, $target, $this);
                    }

                    // Notify all promoters who follow gig artists
                    foreach ($artistGig->artist->artistPromoters as $artistPromoter) {
                        $artistGig->artist->getOrCreateEvent(Event::ARTIST_TRACK, $target, $artistPromoter->promoter);
                    }
                }
                break;
        }
    }

    /**
     * Return Promoters booking data
     * @param array $options
     * @return array
     */
    public function getBookingList($options)
    {
        // Search condition
        $search = isset($options['query']) ? " AND g.name LIKE '%" . $options['query'] . "%' " : "";
        $result = Yii::app()->db->createCommand("
            SELECT g.id, g.name
            FROM gig g
            WHERE g.user_id = " . $this->user_id . $search . " AND g.datetime_from > NOW()
            ORDER BY g.datetime_from DESC
            LIMIT 10;
        ")->queryAll();

        if (empty($result) && $options['force_empty']) {
            $result = Yii::app()->db->createCommand("
                SELECT g.id, g.name
                FROM gig g
                WHERE g.user_id = " . $this->user_id . " AND g.datetime_from > NOW()
                ORDER BY g.datetime_from DESC
                LIMIT 10;
            ")->queryAll();
        }

        return $result;
    }

    private function _getRawPromoterEventsForDashboard()
    {
        // Get list
        $events = Yii::app()->db->createCommand("
            SELECT e.id, e.datetime, e.type, e.status,
                e.init_id, e.init_name, e.init_link,
                e.target_id, e.target_name, e.target_link,
                e.creator_id, e.creator_name, e.creator_link
            FROM event e
            WHERE (e.status = 1 AND e.init_id = " . $this->id . " AND e.type <> " . Event::GIG_CREATE . ")
              OR (e.status = 1 AND e.init_type = 'Promoter' AND e.init_id IN (
                SELECT pp.follow_id
                FROM promoter_promoter pp
                WHERE pp.promoter_id = " . $this->id . "
                  AND e.type <> " . Event::ARTIST_CREATE . "
              ))
              OR (e.status = 1 AND e.init_type = 'Artist' AND e.init_id IN (
                SELECT ap.artist_id
                FROM artist_promoter ap
                WHERE ap.promoter_id = " . $this->id . "
              ))
              OR (e.status = 0 AND
                ((e.init_id = " . $this->id . " AND e.init_type = 'Promoter') OR (e.target_id = " . $this->id . " AND e.target_type = 'Promoter'))
              )
            GROUP BY e.init_id, e.init_type, e.datetime
            ORDER BY e.datetime DESC;
        ")->queryAll();

        // Compile result
        $result = array();
        if ($events) {
            foreach ($events as $event) {
                $follow = array(
                    'type'        => $event['type'],
                    'is_followed' => $event['init_id'] != $this->id,
                    'follow_name' => $event['creator_name'],
                    'follow_link' => $event['creator_link'],
                );

                $event_data = array(
                    'id'    => $event['id'],
                    'date'  => date('D, d M Y', strtotime($event['datetime'])),
                    'type'  => Event::getTypeById($follow),
                    'status'=> $event['status'],
                    'init'  => array(
                        'id'    => $event['init_id'],
                        'name'  => $event['init_name'],
                        'link'  => $event['init_link'],
                    ),
                    'target'=> array(
                        'id'    => $event['target_id'],
                        'name'  => $event['target_name'],
                        'link'  => $event['target_link'],
                    ),
                );

                // Fix self pointer
                if ($event['init_type'] == 'Promoter' && $event['init_id'] == $this->id) {
                    $event_data['init']['name'] = 'You';
                }
                if ($event['target_type'] == 'Promoter' && $event['target_id'] == $this->id) {
                    $event_data['target']['name'] = 'You';
                }

                $result[] = $event_data;
            }
        }

        return $result;
    }

    private function _getRawFollowedArtistsForDashboard()
    {
        // Get list
        $artists = Yii::app()->db->createCommand("
            SELECT a.id, a.name, a.alias, a.description, a.fb_id,
                GROUP_CONCAT(DISTINCT f.path) as files,
                COUNT(DISTINCT ag.id) AS gigCount,
                COUNT(DISTINCT ap.id) AS promoterCount
            FROM artist_promoter ap
            JOIN artist a ON a.id = ap.artist_id
            JOIN artist_gig ag ON ag.artist_id = ap.artist_id
            LEFT JOIN artist_file af ON af.artist_id = a.id
            LEFT JOIN file f ON f.id = af.file_id
            WHERE ap.promoter_id = " . $this->id . "
            GROUP BY ap.artist_id
            ORDER BY ap.timestamp;
        ")->queryAll();

        // Compile result
        $result = array();
        if ($artists) {
            foreach ($artists as $artist) {
                if (!empty($artist['files'])) {
                    $image = '/' . reset(explode(',', $artist['files']));
                } elseif (!empty($artist['fb_id'])) {
                    $image = 'https://graph.facebook.com/' . $artist['fb_id'] . '/picture?type=large';
                } else {
                    $image = '/images/default.png';
                }

                $result[] = array(
                    'id'            => $artist['id'],
                    'image'         => $image,
                    'name'          => $artist['name'],
                    'link'          => '/' . $artist['alias'],
                    'description'   => $artist['description'],
                    'gigCount'      => $artist['gigCount'],
                    'promoterCount' => $artist['promoterCount'],
                    'following'     => 1
                );
            }
        }

        return $result;
    }

    private function _getRawFollowedPromotersForDashboard()
    {
        // Get list
        $promoters = Yii::app()->db->createCommand("
            SELECT p.id, p.name, p.alias, p.description, p.fb_id,
                GROUP_CONCAT(DISTINCT f.path) as files
            FROM promoter_promoter pp
            JOIN promoter p ON p.id = pp.follow_id
            LEFT JOIN promoter_file pf ON pf.promoter_id = pp.follow_id
            LEFT JOIN file f ON f.id = pf.file_id
            WHERE pp.promoter_id = " . $this->id . "
            GROUP BY pp.follow_id
            ORDER BY pp.timestamp;
        ")->queryAll();

        // Compile result
        $result = array();
        if ($promoters) {
            foreach ($promoters as $promoter) {
                if (!empty($promoter['files'])) {
                    $image = '/' . reset(explode(',', $promoter['files']));
                } elseif (!empty($promoter['fb_id'])) {
                    $image = 'https://graph.facebook.com/' . $promoter['fb_id'] . '/picture?type=large';
                } else {
                    $image = '/images/default.png';
                }

                $result[] = array(
                    'id'            => $promoter['id'],
                    'image'         => $image,
                    'name'          => $promoter['name'],
                    'link'          => '/promoter/' . $promoter['alias'],
                    'description'   => $promoter['description'],
                    'following'     => 1
                );
            }
        }

        return $result;
    }

    private function _getRawPromoterGigsForDashboard()
    {
        $result = array();

        // Get gig list
        $gigs = Yii::app()->db->createCommand("
            SELECT g.id, g.name, g.description, g.datetime, g.type, g.capacity,
                v.name AS venue, v.city, c.name AS country
            FROM gig g
            JOIN venue v ON v.id = g.venue_id
            LEFT JOIN country c ON c.id = v.country_id
            WHERE g.user_id = " . $this->user_id . "
            ORDER BY g.timestamp DESC;
        ")->queryAll();

        // Get artists for appropriate gigs
        if (count($gigs)) {
            // Compile result
            foreach ($gigs as $gig) {
                $result[] = array(
                    'id'         => $gig['id'],
                    'name'       => $gig['name'],
                    'date'       => date('d M Y', strtotime($gig['datetime'])),
                    'description'=> $gig['description'],
                    'type'       => Gig::getTypeById($gig['type']),
                    'capacity'   => Gig::getCapacityById($gig['capacity']),
                    'venue'      => array(
                        'name'      => $gig['venue'],
                        'city'      => $gig['city'],
                        'country'   => $gig['country'],
                    )
                );
            }
        }

        return $result;
    }

    /**
     * Create temporary promoter account
     * @return int|null
     */
    public static function getOrCreateTempAccount($account)
    {
        if (!empty($account) && $promoter = self::getByAccount($account)) {
            return $promoter->user_id;
        }

        $promoter = new Promoter;
        $transaction = $promoter->dbConnection->beginTransaction();

        $unique = uniqid();
        $promoter->attributes = array(
            'name'      => $unique,
            'latitude'  => User::getCurrentLatitude(),
            'longitude' => User::getCurrentLatitude(),
            'radius'    => User::getCurrentRadius()
        );
        $promoter->bindRelatedParams(array(
            'email'     => $unique . '@boogi.co',
            'password'  => $unique,
            'role'      => USER::ROLE_PROMOTER,
        ));

        if ($promoter->save()) {
            $transaction->commit();
            return $promoter->user_id;
        }

        return null;
    }

    /**
     * Get promoter by account
     * @param string $account
     * @return Promoter
     */
    public static function getByAccount($account)
    {
        return Promoter::model()->find(
            "MD5(CONCAT('" . Yii::app()->params['baseUrl'] . "', user_id)) = '" . $account . "'"
        );
    }

    /**
     * Merge gigs from account to promoter
     * @param Promoter $account
     * @return bool
     */
    public function mergeAccount($account)
    {
        if ($account) {
            try {
                foreach ($account->user->gigs as $gig) {
                    $gig->user_id = $this->user_id;
                    $gig->save();
                    foreach ($gig->artistGigs as $booking) {
                        $booking->status = ArtistGig::STATUS_OPEN;
                        $booking->save();
                    }
                }
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Delete account
     * @param string $account
     * @return bool
     */
    public static function deleteAccount($account)
    {
        unset(Yii::app()->request->cookies['account']);
        //return $account->delete();
        return false;
    }
}
