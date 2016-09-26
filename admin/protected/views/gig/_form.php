<?php
/* @var $this GigController */
/* @var $model Gig */
/* @var $form CActiveForm */

$newArtistGig = new ArtistGig;
$venue_list = CHtml::listData(Venue::model()->findAll(array('order' => 'name')), 'id', 'name');
?>


<div class="form">

    <?php if (count($venue_list)) { ?>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'gig-form',
            'enableAjaxValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>

        <?php echo $form->hiddenField($model, 'user_id', array('value' => Yii::app()->user->getId())); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <fieldset>
            <legend>General information</legend>
            <div class="row">
                <?php echo $form->labelEx($model, 'venue_id'); ?>
                <?php echo $form->dropDownList($model, 'venue_id', $venue_list); ?>
                <?php echo $form->error($model, 'venue_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'image'); ?>
                <?php echo $form->fileField($model, 'image'); ?>
                <?php echo $form->error($model, 'image'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'datetime_from'); ?>
                <?php echo $form->textField($model, 'datetime_from'); ?>
                <?php echo $form->error($model, 'datetime_from'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'datetime_to'); ?>
                <?php echo $form->textField($model, 'datetime_to'); ?>
                <?php echo $form->error($model, 'datetime_to'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'timezone'); ?>
                <?php echo $form->textField($model, 'timezone'); ?>
                <?php echo $form->error($model, 'timezone'); ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>Link gig to artists</legend>
            <?php if (count($model->artistGigs)) { ?>
                <div class="row">
                    <?php echo $form->labelEx($newArtistGig, 'artist_id'); ?>
                    <?php echo $form->listBox($newArtistGig, 'artist_id', Artist::getArray(), array('multiple' => 'multiple', 'options' => $model->getArtistsSelected(), 'size' => 10)); ?>
                    <?php echo $form->error($newArtistGig, 'artist_id'); ?>
                </div>
            <?php } else { ?>
                <div class="row">
                    <?php echo $form->labelEx($newArtistGig, 'artist_id'); ?>
                    <?php echo $form->listBox($newArtistGig, 'artist_id', Artist::getArray(), array('multiple' => 'multiple', 'size' => 10)); ?>
                    <?php echo $form->error($newArtistGig, 'artist_id'); ?>
                </div>
            <?php } ?>
            <div class="note">Hold down the control or shift button to select multiple Artists</div>
        </fieldset>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
        <?php $this->endWidget(); ?>
    <?php } else { ?>
        <p class="note">
            <span class="required">
                Please add at least one
                <?php echo CHtml::link('Venue', array('venue/create')); ?>.
            </span>
        </p>
    <?php } ?>

</div><!-- form -->