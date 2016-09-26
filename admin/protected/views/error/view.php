<?php
/* @var $this ErrorController */
/* @var $model Error */

$this->breadcrumbs=array(
	'Errors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Error', 'url'=>array('index')),
	array('label'=>'Create Error', 'url'=>array('create')),
	array('label'=>'Update Error', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Error', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Error', 'url'=>array('admin')),
);
?>

<h1>View Error #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'level',
		'category',
		'logtime',
		'message',
	),
)); ?>
