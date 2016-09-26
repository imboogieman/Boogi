<?php

/**
 * This is the model class for table "mailchimp_template".
 *
 * The followings are the available columns in table 'mailchimp_template':
 * @property integer $id
 * @property integer $source_id
 * @property integer $folder_id
 * @property string $name
 * @property string $category
 * @property string $layout
 * @property string $preview_image
 * @property string $date_created
 * @property integer $active
 * @property string $timestamp
 */
class MailchimpTemplate extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mailchimp_template';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('source_id, folder_id, name', 'required'),
            array('source_id, folder_id, active', 'numerical', 'integerOnly' => true),
            array('name, category, layout', 'length', 'max' => 64),
            array('preview_image', 'length', 'max' => 255),
            array('date_created, timestamp', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, source_id, folder_id, name, category, layout, preview_image, date_created, active, timestamp', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'source_id' => 'Source',
            'folder_id' => 'Folder',
            'name' => 'Name',
            'category' => 'Category',
            'layout' => 'Layout',
            'preview_image' => 'Preview Image',
            'date_created' => 'Date Created',
            'active' => 'Active',
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
        $criteria->compare('source_id', $this->source_id);
        $criteria->compare('folder_id', $this->folder_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('category', $this->category, true);
        $criteria->compare('layout', $this->layout, true);
        $criteria->compare('preview_image', $this->preview_image, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MailchimpTemplate the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOrCreateBySourceId($source_id)
    {
        $instance = self::model()->find('source_id = :source_id', array(':source_id' => $source_id));
        if (!$instance) {
            $instance = new MailchimpTemplate();
        }
        return $instance;
    }
}
