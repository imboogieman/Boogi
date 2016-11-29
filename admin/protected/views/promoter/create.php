<?php
/* @var $this PromoterController */
/* @var $model Promoter */

$this->breadcrumbs = array(
    'Promoters' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Promoter', 'url' => array('index')),
    array('label' => 'Manage Promoter', 'url' => array('admin')),
);
?>

    <h1>Create Promoter</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>