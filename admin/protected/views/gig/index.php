<?php
/* @var $this GigController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Gigs',
);

$this->menu = array(
    array('label' => 'Create Gig', 'url' => array('create')),
    array('label' => 'Manage Gig', 'url' => array('admin')),
);
?>

<h1>Gigs</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

<div class="clear"></div>