<?php
    /* @var $this GigController */
    /* @var $model Gig */

    $this->breadcrumbs = array(
        'Gigs' => array('index'),
        $model->name,
    );

    $this->menu = array(
        array('label' => 'List Gig', 'url' => array('index')),
        array('label' => 'Create Gig', 'url' => array('create')),
        array('label' => 'Update Gig', 'url' => array('update', 'id' => $model->id)),
        array('label' => 'Delete Gig', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Gig', 'url' => array('admin')),
    );
    ?>

    <h1><?php echo $model->name; ?></h1>

    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'name',
            array(
                'name' => 'Date/Time From',
                'value' => $model->datetime_from,
            ),
            array(
                'name' => 'Date/Time To',
                'value' => $model->datetime_to,
            ),
            array(
                'name' => 'Timezone',
                'value' => $model->timezone,
            ),
            array(
                'name' => 'Capacity',
                'value' => $model->capacity,
            ),
            array(
                'name' => 'Ticket Price',
                'value' => $model->price,
            ),
            array(
                'name' => 'Currency',
                'value' => $model->getCurrency(),
            ),
            array(
                'name' => 'Type',
                'value' => $model->getType(),
            ),
            array(
                'name' => 'Data Provider',
                'value' => $model->getDataProvider(),
            )
        ),
    ));

    $latitude = $model->venue->latitude ? $model->venue->latitude : Model::getDefaultLatitude();
    $longitude = $model->venue->longitude ? $model->venue->longitude : Model::getDefaultLongitude();

    $config = Yii::app()->params;
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $config['googleApiKey']; ?>&sensor=true"></script>
<script src="<?php echo Yii::app()->params->baseUrl; ?>/js/library/markerwithlabel.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var center = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
            mapOptions = {
                center: center,
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

        // Init map
        var map = new google.maps.Map(document.getElementById('profile-view-map'), mapOptions);

        // User marker
        var marker = new MarkerWithLabel({
            position: center,
            map             : map,
            title           : '<?php echo $model->name; ?>',
            icon            : '/images/m-gig.png',
            labelContent    : '<?php echo $model->getDate("d.m"); ?>',
            labelAnchor     : new google.maps.Point(22, 33),
            labelClass      : 'gigLabel',
            labelStyle      : { opacity: 0.75 }
        });


        var infowindow = new google.maps.InfoWindow({
            content: '<div id="gmap-iw-content"><?php echo CHtml::encode($model->venue->name . ' on ' . $model->getDate()); ?><br /><?php echo CHtml::encode($model->venue->city . ', ' . $model->venue->address); ?></div>'
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    });
</script>

<div id="profile-view-map"></div>
