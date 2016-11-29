<?php
/* @var $this GigController */
/* @var $model Gig */

$this->breadcrumbs = array(
    'Gigs' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List Gig', 'url' => array('index')),
    array('label' => 'Create Gig', 'url' => array('create')),
    array('label' => 'View Gig', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage Gig', 'url' => array('admin')),
);
?>

    <h1>Update Gig <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>