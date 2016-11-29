<?php
/* @var $this ErrorController */
/* @var $model Error */

$this->breadcrumbs=array(
	'Errors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Error', 'url'=>array('index')),
	array('label'=>'Manage Error', 'url'=>array('admin')),
);
?>

<h1>Create Error</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>