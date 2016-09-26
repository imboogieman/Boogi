<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'message-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'gig_id'); ?>
        <?php echo $form->textField($model, 'gig_id'); ?>
        <?php echo $form->error($model, 'gig_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->textField($model, 'type'); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'message'); ?>
        <?php echo $form->textArea($model, 'message', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'message'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'timestamp'); ?>
        <?php echo $form->textField($model, 'timestamp'); ?>
        <?php echo $form->error($model, 'timestamp'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->