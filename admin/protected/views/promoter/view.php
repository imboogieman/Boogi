<?php
    /* @var $this PromoterController */
    /* @var $model Promoter */

    $this->breadcrumbs = array(
        'Promoters' => array('index'),
        $model->name,
    );

    $this->menu = array(
        array('label' => 'List Promoter', 'url' => array('index')),
        array('label' => 'Create Promoter', 'url' => array('create')),
        array('label' => 'Update Promoter', 'url' => array('update', 'id' => $model->id)),
        array('label' => 'Delete Promoter', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Promoter', 'url' => array('admin')),
    );
    ?>

    <h1><?php echo $model->name; ?></h1>

    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id',
            'name',
            'description',
            'fb_id',
            'latitude',
            'longitude',
            'radius'
        ),
    ));

    $latitude = $model->latitude ? $model->latitude : Model::getDefaultLatitude();
    $longitude = $model->longitude ? $model->longitude : Model::getDefaultLongitude();
    $radius = $model->radius ? $model->radius : Model::getDefaultRadius();

    $config = Yii::app()->params;
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $config['googleApiKey']; ?>&sensor=true"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var center = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
            radius = <?php echo $radius; ?>,
            mapOptions = {
                center: center,
                zoom: 4,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

        // Init map
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        // User marker
        var marker = new google.maps.Marker({
            position: center,
            map: map,
            title: 'Your current position',
            icon: '/images/m-promoter.png'
        });

        // User radius
        var circle = new google.maps.Circle({
            map: map,
            radius: parseInt(radius),
            fillColor: '#80CFFF',
            strokeColor: "#0066A4",
            strokeOpacity: 0.8,
            strokeWeight: 2
        });
        circle.bindTo('center', marker, 'position');
    });
</script>

<div id="map-canvas"></div>
