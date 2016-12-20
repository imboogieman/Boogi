<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property integer $id
 * @property string $path
 * @property string $crop
 * @property string $thumb
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property ArtistFile[] $artistFiles
 * @property PromoterFile[] $promoterFiles
 */
class File extends Model
{
    public $image;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'file';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('path', 'length', 'max' => 255),
            array('timestamp', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, path, timestamp', 'safe', 'on' => 'search'),
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
            'artistFiles' => array(self::HAS_MANY, 'ArtistFile', 'file_id'),
            'promoterFiles' => array(self::HAS_MANY, 'PromoterFile', 'file_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'path' => 'Path',
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
        $criteria->compare('path', $this->path, true);
        $criteria->compare('timestamp', $this->timestamp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return File the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function save($runValidation = true, $attributes = null)
    {
        // Call parent save and generates alias
        if (parent::save($runValidation, $attributes)) {
            return true;
        } else {
            foreach(parent::getErrors() as $attribute => $error) {
                foreach($error as $e) {
                    $this->addError($attribute, $e);
                }
            }
            return false;
        }
    }

    public function generateThumbnails()
    {
        $prefix = DOC_ROOT . DS;
        $file = pathinfo($prefix . $this->path);
        if (isset($file['extension']) && in_array($file['extension'], array('jpg', 'jpeg', 'png', 'gif'))) {
            // Convert all images to JPEG
            if (!in_array($file['extension'], array('jpg', 'jpeg'))) {
                $image = Yii::app()->image->load($this->path);
                $new_file = $file['dirname'] . DS . $file['filename'] . '.jpg';
                if ($image->save($new_file)) {
                    $this->path = str_replace($prefix, '', $new_file);
                }
            }

            // Create cropped image
            $image = Yii::app()->image->load($this->path);
            $new_file = $file['dirname'] . DS . $file['filename'] . '-crop.jpg';
            if ($image->crop($image->width, $image->width)->resize(250, 250)->save($new_file)) {
                $this->crop = str_replace($prefix, '', $new_file);
            }

            // Create thumbnail
            $image = Yii::app()->image->load($this->path);
            $new_file = $file['dirname'] . DS . $file['filename'] . '-thumb.jpg';
            if ($image->crop($image->width, $image->width)->resize(50, 50)->save($new_file)) {
                $this->thumb = str_replace($prefix, '', $new_file);
            }

            $this->save();
        }
    }
}
