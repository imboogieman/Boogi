<?php

/**
 * Wrapper class to perform global operation.
 */
class ModelImage
{
    /**
     * @var entity/table name
     */
    protected $_entity_name;
    /**
     * @var related file class
     */
    protected $_related_file_class;
    /**
     * @var related file entity
     */
    protected $_related_file_entity;
    /**
     * @var CActiveRecord
     */
    protected $_model;

    /**
     * Constructor
     * @option CActiveRecord $model
     */
    public function __construct($model)
    {
        // Set model for decoration
        $this->_model = $model;

        // Setup related vars
        $this->_entity_name = $this->_model->tableName();
        $this->_related_file_class = ucfirst($this->_entity_name) . 'File';
        $this->_related_file_entity = $this->_entity_name . 'Files';
    }

    /**
     * Upload file to related model
     * @return bool
     */
    public function save()
    {
        $image = CUploadedFile::getInstance($this->_model, 'image');
        $attributes = $this->_model->attributes;
        unset($attributes['image']);

        if ($this->_model->save()) {
            if ($image) {
                $image_name = 'images/storage/' . $this->_entity_name . '/' . substr(md5(time()), 0, 10) . '.' . $image->getExtensionName();
                if (!$image->getHasError() && $image->saveAs($image_name)) {
                    $file = new File;
                    $file->path = $image_name;
                    if ($file->save()) {
                        if (class_exists($this->_related_file_class)) {
                            $file_relation = new $this->_related_file_class;
                            $file_relation->{$this->_entity_name . '_id'} = $this->_model->id;
                            $file_relation->file_id = $file->id;

                            return $file_relation->save();
                        }
                    }
                }
            } else {
                return true;
            }
        }

        return false;
    }

    public function delete()
    {
        $relations = $this->_model->{$this->_related_file_entity};

        if (count($relations)) {
            foreach ($relations as $relation) {
                $filename = DOC_ROOT . DS . $relation->file->path;
                if (unlink($filename) && $relation->file->delete()) {
                    return $this->_model->delete();
                }
            }
        }

        return $this->_model->delete();
    }
}