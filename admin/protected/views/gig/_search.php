<?php
/* @var $this GigController */
/* @var $model Gig */
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
        <?php echo $form->label($model, 'user_id'); ?>
        <?php echo $form->textField($model, 'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'venue'); ?>
        <?php echo $form->textField($model, 'venue'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 64)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'datetime_from'); ?>
        <?php echo $form->textField($model, 'datetime_from'); ?>
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