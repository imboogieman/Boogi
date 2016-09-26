<?php
/* @var $this GigController */
/* @var $model Gig */

$this->breadcrumbs = array(
    'Gigs' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Gig', 'url' => array('index')),
    array('label' => 'Create Gig', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#gig-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Gigs</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>

<?php echo CHtml::link('Create New Gig', array('gig/create')); ?>

<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'            => 'gig-grid',
    'dataProvider'  => $model->search(),
    'filter'        => $model,
    'columns'       => array(
        'id',
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("view", "id" => $data->id))',
        ),
        array(
            'name'  => 'datetime_from',
            'type'  => 'raw',
            'value' => '$data->getDate()',
        ),
        array(
            'name'  => 'venue',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->venue->name, array("venue/view", "id" => $data->venue_id))',
        ),
        array(
            'name'  => 'ds_type',
            'type'  => 'raw',
            'value' => '$data->getDataProvider()',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
