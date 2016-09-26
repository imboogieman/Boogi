<?php
/* @var $this GigController */
/* @var $model Gig */

$this->breadcrumbs = array(
    'Gigs' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Gig', 'url' => array('index')),
    array('label' => 'Manage Gig', 'url' => array('admin')),
);
?>

    <h1>Create Gig</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>