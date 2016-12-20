<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $id
 * @property integer $gig_id
 * @property integer $artist_id
 * @property integer $type
 * @property string $message
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Gig $gig
 */
class Message extends CActiveRecord
{
    const TYPE_PROMOTER_MESSAGE = 1;
    const TYPE_ARTIST_MESSAGE = 2;
    const TYPE_PROMOTER_UPDATE = 3;
    const TYPE_ARTIST_UPDATE = 4;

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
        return 'message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gig_id, artist_id, type', 'required'),
            array('gig_id, artist_id, type', 'numerical', 'integerOnly' => true),
            array('message, timestamp', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, gig_id, type, message, timestamp', 'safe', 'on' => 'search'),
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
            'gig_id' => 'Gig',
            'artist_id' => 'Artist',
            'type' => 'Type',
            'message' => 'Message',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('gig_id', $this->gig_id);
        $criteria->compare('artist_id', $this->artist_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Return Promoter normalized data
     * @return array
     */
    public function getNormalizedData()
    {
        $data = array(
            'id'            => $this->id,
            'type'          => $this->type,
            'is_promoter'   => $this->type == self::TYPE_PROMOTER_MESSAGE ? 1 : 0,
            'message'       => $this->message,
            'date'          => date('Y-m-d', strtotime($this->timestamp)),
            'time'          => date('H:i', strtotime($this->timestamp))
        );

        return $data;
    }

    /**
     * Return all messages for gig
     * @param int $gig_id
     * @param int $artist_id
     * @return array
     */
    public static function getList($gig_id, $artist_id)
    {
        // Check filters
        $criteria = new CDbCriteria();
        $criteria->addCondition("gig_id = " . $gig_id);
        $criteria->addCondition("artist_id = " . $artist_id);

        // Get list
        $result = array();
        $messages = self::model()->cache(1000, Model::getCacheDependency('message'))
            ->list()->findAll($criteria);

        if ($messages) {
            foreach ($messages as $message) {
                $result[] = $message->getNormalizedData();
            }
        }

        return $result;
    }

    public static function getTypeById($type)
    {
        switch ($type) {
            case self::TYPE_PROMOTER_MESSAGE:
                return 'promoter';
            case self::TYPE_ARTIST_MESSAGE:
                return 'artist';
            case self::TYPE_PROMOTER_UPDATE:
                return 'promoter-update';
            case self::TYPE_ARTIST_UPDATE:
                return 'artist-update';
        }
    }
}
