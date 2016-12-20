<?php
/* @var $this PromoterController */
/* @var $model Promoter */
/* @var $form CActiveForm */

$this->pageTitle = 'Welcome to Starway';

?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'action' => 'promoter/login',
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <?php echo $form->hiddenField($model, 'rememberMe', array('value' => 1)); ?>

    <div class="row">
        <?php echo $form->textField($model, 'email', array('placeholder' => 'email')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->passwordField($model, 'password', array('placeholder' => 'password')); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Stay Tuned!'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
