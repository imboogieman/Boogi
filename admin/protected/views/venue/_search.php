<?php
/* @var $this VenueController */
/* @var $model Venue */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 64)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'country_id'); ?>
        <?php echo $form->textField($model, 'country_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'city'); ?>
        <?php echo $form->textField($model, 'city', array('size' => 60, 'maxlength' => 64)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'address'); ?>
        <?php echo $form->textArea($model, 'address', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'latitude'); ?>
        <?php echo $form->textField($model, 'latitude'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'longitude'); ?>
        <?php echo $form->textField($model, 'longitude'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'timestamp'); ?>
        <?php echo $form->textField($model, 'timestamp'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->