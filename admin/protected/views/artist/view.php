<?php
    /* @var $this ArtistController */
    /* @var $model Artist */

    $this->breadcrumbs = array(
        'Artists' => array('index'),
        $model->name,
    );

    $this->menu = array(
        array('label' => 'List Artist', 'url' => array('index')),
        array('label' => 'Create Artist', 'url' => array('create')),
        array('label' => 'Update Artist', 'url' => array('update', 'id' => $model->id)),
        array('label' => 'Delete Artist', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Artist', 'url' => array('admin')),
    );

    $config = Yii::app()->params;
    $data = $model->getNormalizedData(true);
?>

<h1><?php echo $model->name; ?></h1>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'name',
            'description',
            'images' => array(
                'label' => 'Image link',
                'type' => 'raw',
                'value' => CHtml::link($model->getMainImage(), $model->getMainImage()),
            ),
            'followers' => array(
                'label' => 'Followers',
                'value' => count($model->artistPromoters),
            ),
            'gigs' => array(
                'label' => 'Gigs',
                'value' => count($model->artistGigs),
            ),
            'latitude',
            'longitude'
        ),
    ));

    $latitude = $model->latitude ? $model->latitude : Model::getDefaultLatitude();
    $longitude = $model->longitude ? $model->longitude : Model::getDefaultLongitude();
?>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $config['googleApiKey']; ?>&sensor=true"></script>
<script type="text/javascript" src="<?php echo $config['adminUrl']; ?>/assets/js/markerwithlabel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var data = <?php echo \CJSON::encode($data); ?>,
            mapOptions = {
                center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
                zoom: 4,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

        // Init map
        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        // Artist marker
        var marker = new google.maps.Marker({
            position    : new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
            map         : map,
            title       : data.name,
            icon        : '/images/m-promoter.png'
        });

        // Set gig markers
        for (var i = 0; i < data.gigs.length; i++) {
            var content = '<div id="gmap-iw-content">' + data.gigs[i].name + '<br />' + data.gigs[i].venue.name + '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: content
            });

            marker = new MarkerWithLabel({
                position        : new google.maps.LatLng(data.gigs[i].venue.latitude, data.gigs[i].venue.longitude),
                map             : map,
                title           : data.gigs[i].name + ' @ ' + data.gigs[i].venue.name,
                icon            : '/images/m-gig.png',
                labelClass      : 'gigLabel',
                labelContent    : data.gigs[i].label,
                labelAnchor     : new google.maps.Point(20, 33),
                labelStyle      : { opacity: 0.75 }
            });

            (function(infowindow, marker) {
                google.maps.event.addListener(marker, 'click', function () {
                    infowindow.open(map, marker);
                });
            }(infowindow, marker));
        }
    });
</script>

<div id="map-canvas"></div>
