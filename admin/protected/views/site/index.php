<?php

$this->pageTitle = Yii::app()->name . ' - Dashboard';

$this->breadcrumbs = array(
    'Dashboard',
);

$this->widget('CTabView', array(
    'tabs' => array(
        'tab1' => array(
            'title' => 'Latest Events',
            'view'  => 'events',
            'data'  => array('events' => $events),
        ),
        'tab2' => array(
            'title' => 'Email Templates',
            'view'  => 'emails',
            'data'  => array('emails' => $emails),
        ),
    ),
));
