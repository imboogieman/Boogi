<?php
    $base = Yii::app()->params['baseUrl'];
    $admin = Yii::app()->params['adminUrl'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Boogi API Docs</title>
        <meta charset="utf-8" />
        <meta name="description" content="Boogi API Docs" />
        <meta name="keywords" content="Boogi, API, Docs" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" type="image/png" href="<?php echo $base; ?>/images/favicon/114.png" />
        <link rel="apple-touch-icon" type="image/png" href="<?php echo $base; ?>/images/favicon/57.png" />
        <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="<?php echo $base; ?>/images/favicon/72.png" />
        <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="<?php echo $base; ?>/images/favicon/114.png" />
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo $base; ?>/images/favicon/ie.ico" />

        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" />
        <link rel="stylesheet" type="text/css" href="<?php echo $admin; ?>/css/admin.css" />

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    </head>
    <body class="api">
        <?php echo $content; ?>
    </body>
</html>
