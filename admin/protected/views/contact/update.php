<?php
/* @var $this ContactController */
/* @var $model Contact */

$this->breadcrumbs = array(
    'Contacts' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List Contact', 'url' => array('index')),
    array('label' => 'Create Contact', 'url' => array('create')),
    array('label' => 'View Contact', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage Contact', 'url' => array('admin')),
);
?>

<h1>Update Contact <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>