<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />

        <!--[if lt IE 8]>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div class="container">
            <div id="header">
                <div id="logo"><a href="<?php echo Yii::app()->params['baseUrl']; ?>"><?php echo CHtml::image('/images/logo.png'); ?></a></div>
                <div id="mainmenu">
                    <?php $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array('label' => 'Dashboard', 'url' => array('/site'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Artists', 'url' => array('/artist/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Gigs', 'url' => array('/gig/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Bookings', 'url' => array('/gig/bookings'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Venue', 'url' => array('/venue/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Promoters', 'url' => array('/promoter/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Errors', 'url' => array('/error/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Contacts', 'url' => array('/contact/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Login', 'url' => array('/user/login'), 'visible' => Yii::app()->user->isGuest),
                            array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest)
                        ),
                    )); ?>
                </div>
                <div class="clear"></div>

                <?php
                    $messages = Yii::app()->user->getFlashes();
                    if (count($messages)) {
                        echo '<div class="messages">';
                        foreach ($messages as $key => $message) {
                            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                        }
                        echo '</div>';
                    }
                ?>
                <div class="clear"></div>
            </div>

            <div id="page">

                <?php if (isset($this->breadcrumbs)): ?>
                    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                    )); ?><!-- breadcrumbs -->
                <?php endif ?>

                <div id="content">
                    <?php echo $content; ?>
                    <div class="clear"></div>
                </div>
            </div>

            <div id="footer">
                Version: <?php echo Model::getVersion(); ?>
            </div>
        </div>
    </body>
</html>
