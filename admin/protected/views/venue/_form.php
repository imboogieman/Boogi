<?php
    /* @var $this VenueController */
    /* @var $model Venue */
    /* @var $form CActiveForm */

    $latitude = $model->latitude ? $model->latitude : Model::getDefaultLatitude();
    $longitude = $model->longitude ? $model->longitude : Model::getDefaultLongitude();
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo Yii::app()->params['googleApiKey']; ?>&sensor=true"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var mapOptions = {
                center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

        // Init map
        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        // Artist marker
        var marker = new google.maps.Marker({
            position    : new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
            map         : map,
            draggable   : true,
            title       : '<?php echo $model->name; ?>'
        });

        // Update user position with radius update
        google.maps.event.addListener(marker, 'dragend', function () {
            $('#Venue_latitude').val(this.getPosition().lat());
            $('#Venue_longitude').val(this.getPosition().lng());
        });

        $('#getcoords').click(function () {
            var geocoder = new google.maps.Geocoder();
            var address = $('#Venue_country_id option:selected').html()
                + ', ' + $('#Venue_city').val()
                + ', ' + $('#Venue_address').val();

            geocoder.geocode({ 'address': address }, function (results, status) {
                $('#gmap-results').html('');
                if (status == google.maps.GeocoderStatus.OK) {
                    var location, item, link;

                    for (var i = 0; i < results.length; i++) {
                        location = results[0].geometry.location;

                        link = $('<a class="gmap-item note">click to use</a>');
                        link.data('lat', location.lat()).data('lng', location.lng()).click(function () {
                            $('#Venue_latitude').val($(this).data('lat'));
                            $('#Venue_longitude').val($(this).data('lng'));
                        });

                        item = $('<li>' + results[i].formatted_address + ' </li>');
                        item.append(link);

                        $('#gmap-results').append(item);

                        marker.setPosition(results[0].geometry.location);
                    }
                }
            });
        });
    });
</script>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'venue-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form->hiddenField($model, 'timestamp'); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <legend>General Info</legend>
        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 64)); ?>
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
    </fieldset>

    <fieldset>
        <legend>Location Info</legend>

        <div class="row">
            <?php echo $form->labelEx($model, 'country_id'); ?>
            <?php
            $country_list = CHtml::listData(Country::model()->findAll(array('order' => 'name')), 'id', 'name');
            echo $form->dropDownList($model, 'country_id', $country_list);
            ?>
            <?php echo $form->error($model, 'country_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'city'); ?>
            <?php echo $form->textField($model, 'city', array('size' => 60, 'maxlength' => 64)); ?>
            <?php echo $form->error($model, 'city'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'address'); ?>
            <?php echo $form->textArea($model, 'address', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'address'); ?>
        </div>

        <div class="row gmap-control">
            <a href="#getcoords" id="getcoords">Get coords from Google</a>
            <ol id="gmap-results"></ol>
        </div>

        <div class="row">
            <div class="column">
                <?php echo $form->labelEx($model, 'longitude'); ?>
                <?php echo $form->textField($model, 'longitude', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error($model, 'longitude'); ?>
            </div>

            <div class="column">
                <?php echo $form->labelEx($model, 'latitude'); ?>
                <?php echo $form->textField($model, 'latitude', array('size' => 60, 'maxlength' => 64)); ?>
                <?php echo $form->error($model, 'latitude'); ?>
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