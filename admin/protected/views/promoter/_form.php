<?php
    /* @var $this PromoterController */
    /* @var $model Promoter */
    /* @var $form CActiveForm */

    $latitude = $model->latitude ? $model->latitude : Model::getDefaultLatitude();
    $longitude = $model->longitude ? $model->longitude : Model::getDefaultLongitude();
    $radius = $model->radius ? $model->radius : Model::getDefaultRadius();
?>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Yii::app()->params['googleApiKey']; ?>&sensor=true"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var center = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
            radius = <?php echo $radius; ?>,
            mapOptions = {
                center: center,
                zoom: 5,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

        // Init map
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        // User marker
        var marker = new google.maps.Marker({
            position: center,
            map: map,
            draggable: true,
            title: 'Your current position',
            icon: '/images/m-promoter.png'
        });

        // User radius
        var circle = new google.maps.Circle({
            map: map,
            radius: parseInt(radius),
            editable: true,
            fillColor: '#80CFFF',
            strokeColor: "#0066A4",
            strokeOpacity: 0.8,
            strokeWeight: 2
        });
        circle.bindTo('center', marker, 'position');

        // Update user position with radius update
        google.maps.event.addListener(marker, 'dragend', function () {
            $('#Promoter_latitude').val(this.getPosition().lat());
            $('#Promoter_longitude').val(this.getPosition().lng());

            circle.setCenter(this.getPosition());
        });

        // Update radius slider on map circle change
        google.maps.event.addListener(circle, 'radius_changed', function () {
            $('#Promoter_radius').val(this.getRadius());
        });
    });
</script>

<div id="admin-promoter-profile" class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'promoter-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>

    <?php echo $form->hiddenField($model, 'user_id'); ?>
    <?php echo $form->hiddenField($model, 'timestamp'); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <legend>General Info</legend>

        <?php if ($model->isNewRecord) { ?>
            <div class="row">
                <?php echo $form->labelEx(new User, 'email'); ?>
                <?php echo $form->emailField(new User, 'email', array('size' => 60, 'maxlength' => 254)); ?>
                <?php echo $form->error(new User, 'email'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx(new User, 'password'); ?>
                <?php echo $form->passwordField(new User, 'password', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error(new User, 'password'); ?>
            </div>
        <?php } else { ?>
            <div class="row">
                <?php echo $form->labelEx($model->user, 'email'); ?>
                <?php echo $form->emailField($model->user, 'email', array('size' => 60, 'maxlength' => 254)); ?>
                <?php echo $form->error($model->user, 'email'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model->user, 'password'); ?>
                <?php echo $form->passwordField($model->user, 'password', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error($model->user, 'password'); ?>
            </div>
        <?php } ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 64)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'is_approved'); ?>
            <?php echo $form->checkBox($model, 'is_approved'); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'image'); ?>
            <?php echo $form->fileField($model, 'image'); ?>
            <?php echo $form->error($model, 'image'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'fb_id'); ?>
            <?php echo $form->textField($model, 'fb_id', array('size' => 60, 'maxlength' => 64)); ?>
            <?php echo $form->error($model, 'fb_id'); ?>
        </div>

    </fieldset>

    <fieldset>
        <legend>Location Info</legend>

        <div class="row">
            <div class="column">
                <?php echo $form->labelEx($model, 'latitude'); ?>
                <?php echo $form->textField($model, 'latitude', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error($model, 'latitude'); ?>
            </div>

            <div class="column">
                <?php echo $form->labelEx($model, 'longitude'); ?>
                <?php echo $form->textField($model, 'longitude', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error($model, 'longitude'); ?>
            </div>

            <div class="column">
                <?php echo $form->labelEx($model, 'radius'); ?>
                <?php echo $form->textField($model, 'radius', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error($model, 'radius'); ?>
            </div>

            <div class="clear"></div>
        </div>

        <div class="row notice">You can drag points on map to change your location info</div>

        <div class="row">
            <div id="map-canvas"></div>
        </div>

    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->