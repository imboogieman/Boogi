<?php
/* @var $this VenueController */
/* @var $model Venue */

$this->breadcrumbs = array(
    'Venues' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Venue', 'url' => array('index')),
    array('label' => 'Create Venue', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#venue-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Venues</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>

<?php echo CHtml::link('Create New Venue', array('venue/create')); ?>

<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'venue-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("view", "id" => $data->id))',
        ),
        'description',
        array(
            'name' => 'country',
            'type' => 'raw',
            'value' => '$data->country->name',
        ),
        'city',
        'address',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
