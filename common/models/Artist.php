<?php

/**
 * This is the model class for table "artist".
 *
 * The followings are the available columns in table 'artist':
 * @property integer $id
 * @property integer $user_id
 * @property integer $is_approved
 * @property string $name
 * @property string $alias
 * @property string $image
 * @property string $description
 * @property string $latitude
 * @property string $longitude
 * @property string $timestamp
 * @property int $fb_id
 * @property int $ds_type
 *
 * The followings are the available model relations:
 * @property User $user
 * @property ArtistFile[] $artistFiles
 * @property ArtistGig[] $artistGigs
 * @property ArtistPromoter[] $artistPromoters
 * @property int $gigCount
 *
 * @TODO: Consider refactoring to keep number of methods under 10
 * @TODO: Decrease Overall complexity
 * @TODO: Replace $_COOKIE global variable
 */
class Artist extends Model
{
    public $image;

    public $following;

    public $gigs;

    protected $_related_params = array(
        'gig_id'    => null,
        'email'     => null,
        'password'  => null,
        'role'      => null
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
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'artist';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 64),
            array('alias', 'length', 'max' => 255),
            array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg, gif, png'),
            array('description, timestamp', 'safe'),
            array('is_approved, fb_id, ds_type', 'numerical', 'integerOnly' => true),
            array('latitude, longitude', 'numerical'),
            array('name, alias, description', 'safe', 'on' => 'search'),
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
            'user'              => array(self::BELONGS_TO, 'User', 'user_id'),
            'artistFiles'       => array(self::HAS_MANY, 'ArtistFile', 'artist_id'),
            'artistGigs'        => array(self::HAS_MANY, 'ArtistGig', 'artist_id'),
            'artistPromoters'   => array(self::HAS_MANY, 'ArtistPromoter', 'artist_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => 'ID',
            'name'          => 'Name',
            'is_approved'   => 'Approved',
            'alias'         => 'Alias',
            'image'         => 'Image',
            'description'   => 'Description',
            'fb_id'         => 'Facebook ID',
            'ds_type'       => 'Data Source',
            'latitude'      => 'Latitude',
            'longitude'     => 'Longitude',
            'timestamp'     => 'Timestamp',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('fb_id', $this->fb_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
    }

    /**
     * Save current artist data and update gig relations
     * @return bool
     * @TODO: Decrease Cyclomatic complexity
     */
    public function save($runValidation = true, $attributes = null)
    {
        // Add new relations with gigs
        if (is_array($this->_related_params['gig_id']) && $this->id) {
            // Delete all old relations with gigs
            ArtistGig::model('ArtistGig')->deleteAll('artist_id = ?', array($this->id));

            // Add new records
            foreach ($this->_related_params['gig_id'] as $gig_id) {
                $artistGig = new ArtistGig;
                $artistGig->artist_id = $this->id;
                $artistGig->gig_id = $gig_id;
                $artistGig->save();
            }
        }

        // Update user params
        if (isset($this->_related_params['email']) && isset($this->_related_params['password'])) {
            if ($this->user_id) {
                $this->user->email = $this->_related_params['email'];
                $this->user->role = User::ROLE_ARTIST;

                // Check password update
                if ($this->_related_params['password'] != '********') {
                    $this->user->password = CPasswordHelper::hashPassword($this->_related_params['password']);
                }

                if (!$this->user->save()) return false;
            } else {
                $user = new User;
                $user->email = $this->_related_params['email'];
                $user->role = User::ROLE_ARTIST;

                // Check password update
                if ($this->_related_params['password'] != '********') {
                    $user->password = CPasswordHelper::hashPassword($this->_related_params['password']);
                }

                if ($user->save()) {
                    $this->setAttribute('user_id', $user->id);
                } else {
                    $this->addErrors($user->getErrors());
                    return false;
                }
            }
        }

        // Call parent save and generates alias
        if (parent::save($runValidation, $attributes)) {
            $this->generateAlias();
            return true;
        }
    }

    /**
     * Return list of linked files
     * @return array
     */
    public function getFiles()
    {
        $result = array();
        foreach ($this->artistFiles as $file) {
            $result[$file->file_id] = $file->file->path;
        }
        return $result;
    }

    /**
     * Return list of related gigs
     * @return array
     * @TODO: Decrease Cyclomatic complexity
     */
    public function getGigs()
    {
        // Get logged promoter
        $promoter = Promoter::getLogged();

        // Compile result
        $result = array();
        foreach ($this->artistGigs as $artistGig) {
            if ($artistGig->gig) {
                $data = $artistGig->gig->getNormalizedData(true, false);

                // Check radius
                if ($promoter && $promoter->latitude && $promoter->longitude && $promoter->radius) {
                    $distance = Model::distance($data['venue']['latitude'], $data['venue']['longitude'], $promoter->latitude, $promoter->longitude);
                    if ($distance <= ($promoter->radius / 1000)) {
                        $data['inRadius'] = 1;
                    } else {
                        $data['inRadius'] = 0;
                    }
                } elseif (isset($_COOKIE['latitude']) && isset($_COOKIE['longitude'])) {
                    $distance = Model::distance($data['venue']['latitude'], $data['venue']['longitude'], $_COOKIE['latitude'], $_COOKIE['longitude']);
                    if ($distance <= (Model::DEFAULT_RADIUS / 1000)) {
                        $data['inRadius'] = 1;
                    } else {
                        $data['inRadius'] = 0;
                    }
                }

                $result[] = $data;
            } else {
                $artistGig->delete();
            }
        }
        return $result;
    }

    /**
     * Return selection options array for CHtml::listBox
     * @return array
     */
    public function getGigsSelected()
    {
        $result = array();
        foreach ($this->artistGigs as $artistGig) {
            $result[$artistGig->gig_id] = array('selected' => 'selected');
        }
        return $result;
    }

    /**
     * Get artists assoc array
     * @return array
     */
    public static function getArray()
    {
        return CHtml::listData(self::model()->findAll(), 'id', 'name');
    }

    /**
     * Check if current user follow this artist
     * @return bool
     */
    public function isCurrentUserFollowing()
    {
        // Check command mode
        if (!Yii::app()->hasProperty('user')) return false;

        // Check if not guest
        if (!Yii::app()->user->isGuest) {
            $user_id = Yii::app()->user->getId();
            foreach ($this->artistPromoters as $artistPromoter) {
                if ($artistPromoter->promoter->user_id == $user_id) return true;
            }
        }

        return false;
    }

    /**
     * Get artist list
     * @return array
     */
    public static function getList()
    {
        // Get list
        $result = array();
        $artists = self::model()->cache(1000, Model::getCacheDependency('artist_list'))
            ->with('artistPromoters', 'artistGigs', 'artistFiles')->findAll();

        if ($artists) {
            foreach ($artists as $artist) {
                $result[] = $artist->getNormalizedData();
            }
        }

        usort($result, array('self', 'sortByGigCount'));
        return $result;
    }

    /**
     * Alias for get artist method
     * @param int $id
     * @param string|null $alias
     * @return array|bool
     */
    public static function getForMap($id, $alias = null)
    {
        if (!empty($id) && $artist = Artist::model()->findByPk($id)) {
            return $artist->getNormalizedData();
        } elseif (!empty($alias) && $artist = Artist::model()->findByAlias($alias)) {
            return $artist->getNormalizedData();
        } else {
            return false;
        }
    }

    /**
     * Return Artist normalized data
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
            $data['email']          = $this->user ? $this->user->email : Yii::app()->params['adminEmail'];
            $data['is_approved']    = $this->is_approved;
            $data['description']    = $this->description;
            $data['latitude']       = $this->latitude;
            $data['longitude']      = $this->longitude;
            $data['image']          = $this->getMainImage();
            $data['gigs']           = $this->getGigs();
            $data['gigCount']       = count($this->artistGigs);
            $data['promoterCount']  = count($this->artistPromoters);
            $data['following']      = $this->isCurrentUserFollowing();
            $data['fb_id']          = $this->fb_id;
            $data['ds_type']        = $this->ds_type;
        }

        return $data;
    }

    /**
     * Sort artist by gigs count
     * @param Artist $a
     * @param Artist $b
     * @return int
     */
    private static function sortByGigCount($a, $b)
    {
        if ($a['gigCount'] == $b['gigCount']) {
            return 0;
        }
        return ($a['gigCount'] > $b['gigCount']) ? -1 : 1;
    }

    /**
     * Find artist by alias
     * @param string $alias
     * @return Artist
     */
    public function findByAlias($alias)
    {
        return Artist::model()->find('alias = :alias', array(':alias' => $alias));
    }

    /**
     * Search artists by query
     * @param string $query
     * @return Artist[]|null
     */
    public function searchByQuery($query)
    {
        $result = array();

        $artists = Artist::model()->findAll('name LIKE :query', array(
            ':query' => '%' . $query . '%'
        ));

        foreach ($artists as $artist) {
            $result[] = $artist->getNormalizedData();
        }

        return $result;
    }

    /**
     * Return artist frontend link
     * @return string
     */
    public function getLink()
    {
        return '/' . $this->alias;
    }

    /**
     * Return logged artist
     * @return Artist $artist
     */
    public static function getLogged()
    {
        if (php_sapi_name() == 'cli') {
            return false;
        }

        if ($user_id = Yii::app()->user->getId()) {
            return Artist::model()->with('artistPromoters','artistFiles','artistGigs')
                ->find('user_id = :user_id', array(':user_id' => $user_id));
        }
    }

    public function getDSType()
    {
        return DataSource::getName($this->ds_type);
    }

    /**
     * Return Promoters dashboard data
     * @return array
     */
    public function getDashboardData()
    {
        // Promoter bookings
        $bookings = array();
        $artistGigs = ArtistGig::model()->cache(1000, Model::getCacheDependency('artist_gig'))
            ->findAll('artist_id = :artist_id', array(':artist_id' => $this->id));

        foreach ($artistGigs as $item) {
            $bookings[] = $item->getBookingItemData();
        }

        // Compiled data
        $data = array(
            'bookings'  => $bookings,
        );

        return $data;
    }
    
    /**
     * Update artist data
     * @return int Update status
     */
    public function updateData()
    {
        // Check alias
        try {
            $this->alias = Model::createAlias($this->name);
            $this->save();
        } catch (Exception $e) {
            Command::error($e->getMessage());
            return Model::STATUS_ERROR;
        }

        // Check user record
        if (!$this->user) {
            $user = new User;

            $user->email = $this->alias . '@boogi.co';
            $user->password = CPasswordHelper::hashPassword('starway2014');
            $user->role = USER::ROLE_ARTIST;

            if ($user->save()) {
                $this->user_id = $user->id;
                if ($this->save()) {
                    return Model::STATUS_UPDATED;
                } else {
                    return Model::STATUS_ERROR;
                }
            } else {
                return Model::STATUS_ERROR;
            }
        }

        return Model::STATUS_SKIPPED;
    }
    
    /**
     * Generate alias from name
     * @param bool $force
     * @return bool
     */
    public function generateAlias($force = false)
    {
        if (empty($this->alias) || $force) {
            $alias = Model::createAlias($this->name);

            // Check duplicates
            $duplicates = Artist::model()->find("alias = '" . $alias . "'");
            if ($duplicates) {
                $alias = $this->id . ($alias ? '-' . $alias : '');
            }

            $this->alias = substr($alias, 0, 64);
            return $this->save();
        }
    }
}
