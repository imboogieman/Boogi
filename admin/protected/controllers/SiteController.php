<?php

// @TODO: Replace $_GET and $_POST globals

class SiteController extends Controller
{
    public $layout = '//layouts/index';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'   => array('error'),
                'users'     => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'   => array('index', 'email'),
                'users'     => Model::$admin_emails,
            ),
            array('deny', // deny all users
                'users'     => array('*'),
            ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionIndex()
    {
        // Get Event data provider
        $events = new Event('search');
        $events->unsetAttributes();

        if (isset($_GET['Event'])) {
            $events->attributes = $_GET['Event'];
        }

        // Get Git commits
        ob_start();
        system('git log -n 30 --pretty=format:"%ar: %s;"');
        $commits = ob_get_contents();
        $commits = explode(';', $commits);
        ob_end_clean();

        $opt = array('target' => '_blank');
        $emails = array(
            CHtml::link('You have an update on your booking', '/site/email?t=' . Event::BOOKING_UPDATE, $opt),
            CHtml::link('Artist has confirmed a new gig', '/site/email?t=' . Event::BOOKING_CREATE, $opt),
            CHtml::link('Your follower has made a new booking', '/site/email?t=' . Event::BOOKING_TRACK, $opt),
            CHtml::link('Your follower is now following artist', '/site/email?t=' . Event::FOLLOW_ARTIST, $opt),
            CHtml::link('Your follower is now following promoter', '/site/email?t=' . Event::FOLLOW_PROMOTER, $opt),
            CHtml::link('Your follower is now not following artist', '/site/email?t=' . Event::UNFOLLOW_ARTIST, $opt),
            CHtml::link('Your follower is now not following promoter', '/site/email?t=' . Event::UNFOLLOW_PROMOTER, $opt),
            CHtml::link('New artist is in the game', '/site/email?t=' . Event::ARTIST_CREATE, $opt),
            CHtml::link('Your follower has made a new booking', '/site/email?t=' . Event::ARTIST_TRACK, $opt),
            CHtml::link('Artist added a new gig', '/site/email?t=' . Event::GIG_CREATE, $opt),
            CHtml::link('New promoter is in the game', '/site/email?t=' . Event::PROMOTER_CREATE, $opt),
        );

        $this->render('index', array(
            'events'  => $events,
            'commits' => $commits,
            'emails'  => $emails
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionEmail()
    {
        $this->layout = 'email';
        $request = Yii::app()->request;

        if ($id = $request->getQuery('id')) {
            if ($event = Event::model()->findByPk($id)) {
                $eventEmail = new EventEmail($event);
                echo $eventEmail->getMessage();
            } else {
                $this->render('error', array(
                    'code'      => '0x0011',
                    'message'   => 'Cant find event #' . $id
                ));
                return;
            }
        } else {
            $type = $request->getQuery('t');
            echo EventEmail::getDummyMessage($type);
        }
    }

}
