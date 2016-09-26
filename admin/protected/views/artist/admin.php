<?php
/* @var $this ArtistController */
/* @var $model Artist */

$this->breadcrumbs = array(
    'Artists' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Artist', 'url' => array('index')),
    array('label' => 'Create Artist', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#artist-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Artists</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>

<?php echo CHtml::link('Create New Artist', array('artist/create')); ?>

<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'artist-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("view", "id" => $data->id))',
        ),
        array(
            'name' => 'fb_id',
            'type' => 'raw',
            'value' => '$data->fb_id ? CHtml::link($data->fb_id, "https://www.facebook.com/" . $data->fb_id) : ""',
        ),
        'description',
        array(
            'name' => 'ds_type',
            'value' => '$data->getDSType()',
        ),
        array(
            'name' => 'timestamp',
            'value' => '$data->getDate()',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
