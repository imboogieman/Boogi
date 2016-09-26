<?php
$user = User::getLogged();
$config = array(
    'isDebug'       => Yii::app()->params['isDebug'],
    'enableStats'   => Yii::app()->params['enableStats'],
    'user'          => $user ? $user->getNormalizedData(true, true) : null,
    'bookStatuses'  => ArtistGig::getStatusesList(),
    'venueAttrs'    => Gig::getAttributesList(),
    'allowedTags'   => Model::$allowed_tags,
    'params' => array(
        'baseUrl'       => Yii::app()->params['baseUrl'],
        'adminUrl'      => Yii::app()->params['adminUrl'],
        'liveToolbar'   => Yii::app()->params['liveToolbar'],
        'googleApiKey'  => Yii::app()->params['googleApiKey'],

        'defaultPosition' => array(
            'latitude'      => Model::getDefaultLatitude(),
            'longitude'     => Model::getDefaultLongitude(),
            'radius'        => Model::getDefaultRadius()
        ),

        'listMapZoom'   => 5,
        'itemMapZoom'   => 10,
        'gaCounter'     => Yii::app()->params['gaCounter'],
        'gaDomain'      => Yii::app()->params['gaDomain'],
        'yaCounter'     => Yii::app()->params['yaCounter']
    ),
    'apiStatusDict'     => ApiStatus::getDict(),
    'featuredArtists'   => ArtistApi::getFeaturedArtists(),
    'artistsCount'      => ArtistApi::getArtistsCount(),
    'tzInfo'            => TZInfo::getAll(),
    'defaultTZ'         => TZInfo::getDefault()
);

$base = Yii::app()->request->baseUrl;
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Yii::app()->params['metatitle']; ?></title>
        <meta charset="utf-8" />
        <meta name="description" content="<?php echo Yii::app()->params['metadesc']; ?>" />
        <meta name="keywords" content="<?php echo Yii::app()->params['metakeys']; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" type="image/png" href="<?php echo $base; ?>/images/favicon/114.png" />
        <link rel="apple-touch-icon" type="image/png" href="<?php echo $base; ?>/images/favicon/57.png" />
        <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="<?php echo $base; ?>/images/favicon/72.png" />
        <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="<?php echo $base; ?>/images/favicon/114.png" />
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo $base; ?>/images/favicon/ie.ico" />
        <link rel="image_src" href="<?php echo $base; ?>/images/favicon/114.png">

        <link href="http://cdn.alloyui.com/3.0.1/aui-css/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" />
        <link rel="stylesheet" type="text/css" href="<?php echo Less::getLink(); ?>" />

        <script type="text/javascript">
            window.appConfig = <?php echo \CJSON::encode($config); ?>;
        </script>

        <script src="http://cdn.alloyui.com/3.0.1/aui/aui-min.js"></script>
        <?php if (Yii::app()->params['isDebug']): ?>
            <script type="text/javascript" src="<?php echo $base; ?>/js/index.js"></script>
        <?php else: ?>
            <script type="text/javascript" src="<?php echo YUICompressor::getLink(); ?>"></script>
        <?php endif; ?>
    </head>
    <body class="yui3-skin-sam">

        <?php echo $content; ?>

        <?php if (Yii::app()->params['enableStats']) : ?>
            <!-- Google Analytics counter -->
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                ga('create', '<?php echo $config['params']['gaCounter']; ?>', '<?php echo $config['params']['gaDomain']; ?>');
            </script>
            <!-- /Google Analytics counter -->

            <!-- Yandex.Metrika counter -->
            <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function() {
                        try {
                            w.yaCounter<?php echo $config['params']['yaCounter']; ?> = new Ya.Metrika({
                                id                  : <?php echo $config['params']['yaCounter']; ?>,
                                webvisor            : true,
                                clickmap            : true,
                                trackLinks          : true,
                                accurateTrackBounce : true,
                                trackHash           : true
                            });
                        } catch(e) { }
                    });

                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () { n.parentNode.insertBefore(s, n); };

                    s.type = "text/javascript";
                    s.async = true;
                    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else {
                        f();
                    }
                })(document, window, "yandex_metrika_callbacks");
            </script>
            <noscript>
                <div>
                    <img src="//mc.yandex.ru/watch/<?php echo $config['params']['yaCounter']; ?>" style="position:absolute; left:-9999px;" alt="" />
                </div>
            </noscript>
            <!-- /Yandex.Metrika counter -->

            <!-- CrazyEgg hitmap -->
            <script type="text/javascript">
                setTimeout(function(){var a=document.createElement("script");
                    var b=document.getElementsByTagName("script")[0];
                    a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0029/0385.js?"+Math.floor(new Date().getTime()/3600000);
                    a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
            </script>
            <!-- /CrazyEgg hitmap -->
        <?php endif; ?>
    </body>
</html>
