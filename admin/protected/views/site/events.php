<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'            => 'event-grid',
    'dataProvider'  => $events->search(),
    'filter'        => $events,
    'columns'       => array(
        'id',
        array(
            'name'  => 'init_id',
            'type'  => 'raw',
            'value' => '$data->getInitLink()'
        ),
        array(
            'name'  => 'type',
            'type'  => 'raw',
            'value' => '$data->getType()',
        ),
        array(
            'name'  => 'target_id',
            'type'  => 'raw',
            'value' => '$data->getTargetLink()'
        ),
        array(
            'name'  => 'creator_id',
            'type'  => 'raw',
            'value' => '$data->getCreatorLink()'
        ),
        array(
            'name'  => 'timestamp',
            'type'  => 'raw',
            'value' => '$data->getDate()',
        ),
        array(
            'name'  => 'id',
            'type'  => 'raw',
            'value' => '$data->getEmailLink()',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));