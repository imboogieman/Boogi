<?php

/**
 * This is the model class for table "user_email".
 *
 * The followings are the available columns in table 'user_email':
 * @property integer $id
 * @property integer $user_id
 * @property integer $radar_enabled
 * @property string $radar_last_sent
 * @property integer $reply_enabled
 * @property string $reply_last_sent
 * @property integer $retention_enabled
 * @property string $retention_last_sent
 * @property integer $retention_14_enabled
 * @property string $retention_14_last_sent
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserEmail extends Model
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_email';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('user_id, radar_enabled, reply_enabled, retention_sent, retention_14_sent', 'numerical', 'integerOnly' => true),
            array('timestamp', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, radar_enabled, radar_last_sent, reply_enabled, reply_last_sent, retention_sent, retention_14_sent, timestamp', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'radar_enabled' => 'Radar Enabled',
            'radar_last_sent' => 'Radar Last Sent',
            'reply_enabled' => 'Reply Enabled',
            'reply_last_sent' => 'Reply Last Sent',
            'retention_sent' => 'Retention Last Sent',
            'retention_14_sent' => 'Retention 14 Last Sent',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('radar_enabled', $this->radar_enabled);
        $criteria->compare('radar_last_sent', $this->radar_last_sent, true);
        $criteria->compare('reply_enabled', $this->reply_enabled);
        $criteria->compare('reply_last_sent', $this->reply_last_sent, true);
        $criteria->compare('retention_enabled', $this->retention_enabled);
        $criteria->compare('retention_last_sent', $this->retention_last_sent, true);
        $criteria->compare('retention_14_enabled', $this->retention_14_enabled);
        $criteria->compare('retention_14_last_sent', $this->retention_14_last_sent, true);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserEmail the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
