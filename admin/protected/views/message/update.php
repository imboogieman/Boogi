<?php
/* @var $this MessageController */
/* @var $model Message */

$this->breadcrumbs = array(
    'Messages' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List Message', 'url' => array('index')),
    array('label' => 'Create Message', 'url' => array('create')),
    array('label' => 'View Message', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage Message', 'url' => array('admin')),
);
?>

    <h1>Update Message <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>