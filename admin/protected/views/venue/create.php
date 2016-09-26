<?php
/* @var $this VenueController */
/* @var $model Venue */

$this->breadcrumbs = array(
    'Venues' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Venue', 'url' => array('index')),
    array('label' => 'Manage Venue', 'url' => array('admin')),
);
?>

    <h1>Create Venue</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>