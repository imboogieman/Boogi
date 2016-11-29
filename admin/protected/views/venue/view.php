<?php
/* @var $this VenueController */
/* @var $model Venue */

$this->breadcrumbs = array(
    'Venues' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Venue', 'url' => array('index')),
    array('label' => 'Create Venue', 'url' => array('create')),
    array('label' => 'Update Venue', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Venue', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Venue', 'url' => array('admin')),
);

$config = Yii::app()->params;
?>

<h1><?php echo $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        'country.name',
        'city',
        'address',
        'latitude',
        'longitude',
    ),
));
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $config['googleApiKey']; ?>&sensor=true"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var mapOptions = {
            center: new google.maps.LatLng(<?php echo $model->latitude; ?>, <?php echo $model->longitude; ?>),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        // Init map
        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        var infowindow = new google.maps.InfoWindow({
            content: '<div id="gmap-iw-content"><?php echo CHtml::encode($model->city . ', ' . $model->address); ?></div>'
        });

        var marker = new google.maps.Marker({
            position: mapOptions.center,
            map     : map,
            title   : '<?php echo $model->name; ?>',
            icon    : '/images/m-venue.png'
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    });
</script>

<div id="map-canvas"></div>