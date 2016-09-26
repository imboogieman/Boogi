<?php
/* @var $this ErrorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Errors',
);

$this->menu=array(
	array('label'=>'Create Error', 'url'=>array('create')),
	array('label'=>'Manage Error', 'url'=>array('admin')),
);
?>

<h1>Errors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
