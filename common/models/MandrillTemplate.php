<?php

/**
 * This is the model class for table "mandrill_template".
 *
 * The followings are the available columns in table 'mandrill_template':
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $labels
 * @property string $code
 * @property string $subject
 * @property string $from_email
 * @property string $from_name
 * @property string $text
 * @property string $publish_name
 * @property string $publish_code
 * @property string $publish_subject
 * @property string $publish_from_email
 * @property string $publish_from_name
 * @property string $publish_text
 * @property string $published_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $timestamp
 */
class MandrillTemplate extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mandrill_template';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('slug, name', 'required'),
            array('slug, name, labels, subject, from_email, from_name, publish_name, publish_subject, publish_from_email, publish_from_name', 'length', 'max' => 64),
            array('code, text, publish_code, publish_text, published_at, created_at, updated_at, timestamp', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, slug, name, labels, code, subject, from_email, from_name, text, publish_name, publish_code, publish_subject, publish_from_email, publish_from_name, publish_text, published_at, created_at, updated_at, timestamp', 'safe', 'on' => 'search'),
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
            'slug' => 'Slug',
            'name' => 'Name',
            'labels' => 'Labels',
            'code' => 'Code',
            'subject' => 'Subject',
            'from_email' => 'From Email',
            'from_name' => 'From Name',
            'text' => 'Text',
            'publish_name' => 'Publish Name',
            'publish_code' => 'Publish Code',
            'publish_subject' => 'Publish Subject',
            'publish_from_email' => 'Publish From Email',
            'publish_from_name' => 'Publish From Name',
            'publish_text' => 'Publish Text',
            'published_at' => 'Published At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('labels', $this->labels, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('from_email', $this->from_email, true);
        $criteria->compare('from_name', $this->from_name, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('publish_name', $this->publish_name, true);
        $criteria->compare('publish_code', $this->publish_code, true);
        $criteria->compare('publish_subject', $this->publish_subject, true);
        $criteria->compare('publish_from_email', $this->publish_from_email, true);
        $criteria->compare('publish_from_name', $this->publish_from_name, true);
        $criteria->compare('publish_text', $this->publish_text, true);
        $criteria->compare('published_at', $this->published_at, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MandrillTemplate the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOrCreateBySlug($slug)
    {
        $instance = self::model()->find('slug = :slug', array(':slug' => $slug));
        if (!$instance) {
            $instance = new MandrillTemplate();
        }
        return $instance;
    }
}
