<?php

/**
 * This is the model class for table "promoter_file".
 *
 * The followings are the available columns in table 'promoter_file':
 * @property integer $id
 * @property integer $promoter_id
 * @property integer $file_id
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Promoter $promoter
 * @property File $file
 */
class PromoterFile extends Model
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'promoter_file';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('promoter_id, file_id', 'required'),
            array('promoter_id, file_id', 'numerical', 'integerOnly' => true),
            array('timestamp', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, promoter_id, file_id, timestamp', 'safe', 'on' => 'search'),
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
            'promoter' => array(self::BELONGS_TO, 'Promoter', 'promoter_id'),
            'file' => array(self::BELONGS_TO, 'File', 'file_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'promoter_id' => 'Promoter',
            'file_id' => 'File',
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
        $criteria->compare('promoter_id', $this->promoter_id);
        $criteria->compare('file_id', $this->file_id);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PromoterFile the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
