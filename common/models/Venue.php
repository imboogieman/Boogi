<?php

/**
 * This is the model class for table "venue".
 *
 * The followings are the available columns in table 'venue':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property integer $country_id
 * @property string $city
 * @property string $address
 * @property double $latitude
 * @property double $longitude
 * @property string $timestamp
 * @property string $ds_id
 * @property integer $ds_type
 *
 * The followings are the available model relations:
 * @property Gig[] $gigs
 * @property Country $country
 * @property VenueFile[] $venueFiles
 *
 * @TODO: Decrease Overall complexity
 * @TODO: Replace $_REQUEST global variable
 */
class Venue extends Model
{
    public $image;

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
        return 'venue';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country_id', 'numerical', 'integerOnly' => true),
            array('latitude, longitude', 'numerical'),
            array('name, city', 'length', 'max' => 64),
            array('description, address, timestamp', 'safe'),
            array('id, name, description, country_id, city, address, latitude, longitude, timestamp', 'safe', 'on' => 'search'),
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
            'gigs' => array(self::HAS_MANY, 'Gig', 'venue_id'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
            'venueFiles' => array(self::HAS_MANY, 'VenueFile', 'venue_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Venue Name',
            'description' => 'Description',
            'country_id' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'timestamp' => 'Timestamp',
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
        $criteria->compare('name', $this->name, true);

        if (isset($_REQUEST['Venue']) && isset($_REQUEST['Venue']['country'])) {
            $country = Country::model()->find('name LIKE :name', array(
                ':name' => '%' . $_REQUEST['Venue']['country'] . '%'
            ));
            $criteria->compare('country_id', $country ? $country->id : null);
        }

        $criteria->compare('description', $this->description, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('latitude', $this->latitude);
        $criteria->compare('longitude', $this->longitude);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
    }

    /**
     * Get venues assoc array
     * @return array
     */
    public static function getArray()
    {
        $result = array();

        $venues = Venue::model()->findAll();
        foreach($venues as $venue) {
            $result[] = array(
                'id' => $venue->id,
                'name' => $venue->name,
            );
        }

        return $result;
    }

    /**
     * Save action with related User creation
     * @return bool|void
     */
    public function save($runValidation = true, $attributes = null)
    {
        if (empty($this->name) && empty($this->city) && empty($this->address) &&
            empty($this->latitude) && empty($this->longitude))
        {
            $this->addError('address', 'Empty all address fields.');
            return false;
        }

        // Call parent save
        if (parent::save($runValidation, $attributes)) {
            // Generates alias
            $this->generateAlias();

            return true;
        }
    }

    /**
     * Return venue list
     * @return array
     */
    public static function getList()
    {
        // Get list
        $result = array();
        $venues = self::model()->cache(1000, Model::getCacheDependency('venue'))
            ->with('country')->list()->findAll();

        if ($venues) {
            foreach ($venues as $venue) {
                $result[] = $venue->getNormalizedData();
            }
        }

        return $result;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Venue the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Return Venue normalized data
     * @param bool $required
     * @return array
     */
    public function getNormalizedData($required = true)
    {
        $data = array(
            'id'            => $this->id,
            'name'          => $this->name,
            'link'          => $this->getLink(),
            'latitude'      => $this->latitude,
            'longitude'     => $this->longitude,
            'date'          => $this->getDate()
        );

        if ($required) {
            $data['description']    = $this->description;
            $data['country']        = $this->country->name;
            $data['city']           = $this->city;
            $data['address']        = $this->address;
            $data['image']          = $this->getMainImage();
        }

        return $data;
    }

    /**
     * Return venue frontend link
     * @return string
     */
    public function getLink()
    {
        return '/venue/' . $this->alias;
    }

    /**
     * Delete unused venues
     * @TODO: Optimize check for venue gigs
     * @return int $deleted
     */
    public static function clean()
    {
        $deleted = 0;

        // Delete venues without Gigs
        $venues = self::model()->findAll();
        foreach ($venues as $venue) {
            if (count($venue->gigs) == 0) {
                if ($venue->delete()) $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Merge venues with the same coords
     * @return int $merged
     */
    public static function merge()
    {
        // Get all Venues
        $venues = Venue::model()->findAll('latitude IS NOT NULL AND longitude IS NOT NULL');

        // Create unique and for delete arrays
        $unique = array();
        $merged = array();
        foreach ($venues as $venue) {
            $index = md5($venue->latitude . $venue->longitude);
            if (isset($unique[$index])) {
                $merged[$unique[$index]][] = $venue->id;
            } else {
                $unique[$index] = $venue->id;
                $merged[$venue->id] = array();
            }
        }

        // Update gigs venues
        $mergedCount = 0;
        foreach ($merged as $replace => $search) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('venue_id', $search);
            $mergedCount += Gig::model()->updateAll(array('venue_id' => $replace), $criteria);
        }

        return $mergedCount;
    }

    /**
     * Update venue data
     * @return int Update status
     * @TODO: Decrease Cyclomatic and NPath complexity
     */
    public function updateData()
    {
        // Check links
        if (count($this->gigs) == 0) {
            $this->delete();
            return Model::STATUS_DELETED;
        }

        // Update fields
        if ($this->latitude && $this->longitude && (empty($this->country_id) || empty($this->name))) {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' .
                $this->latitude . ',' . $this->longitude . '&sensor=false';
            $data = file_get_contents($url);
            $data = \CJSON::decode($data);

            if (count($data) && isset($data['results'][0])) {
                if (empty($this->country_id)) {
                    $country_name = DataSource::getGoogleGCResponseValue('country', $data['results'][0]);
                    if ($country_name) {
                        $country = Country::model()->getByName($country_name);
                        if ($country) {
                            $this->country_id = $country->id;
                        }
                    }
                }

                if (empty($this->city)) {
                    $city = DataSource::getGoogleGCResponseValue('sublocality', $data['results'][0]);
                    if ($city) {
                        $this->city = $city;
                    }
                }

                $address = array();
                if (empty($this->address)) {
                    $address[] = DataSource::getGoogleGCResponseValue('street_number', $data['results'][0]);
                    $address[] = DataSource::getGoogleGCResponseValue('route', $data['results'][0]);
                    $this->address = implode(' ', $address);
                }

                if (empty($this->name)) {
                    $country = Country::model()->findByPk($this->country_id);
                    $this->name  = $this->address;
                    $this->name .= !empty($this->address) ? ',' . $this->city : '';
                    $this->name .= !empty($this->city) ? ',' . $country->name : '';
                }

                $this->generateAlias(true);
                return $this->save() ? Model::STATUS_UPDATED : Model::STATUS_ERROR;
            }
        }

        return Model::STATUS_SKIPPED;
    }

    /**
     * Return Venue full name
     * @return string
     */
    public function getFullName()
    {
        $result = array($this->name);

        if (!empty($this->address)) {
            $result[] = $this->address;
        }

        if (!empty($this->city)) {
            $result[] = $this->city;
        }

        $country = Country::model()->findByPk($this->country_id);
        if ($country) {
            $result[] = $country->name;
        }

        return implode(', ', $result);
    }
}
