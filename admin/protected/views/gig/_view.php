<?php
/* @var $this GigController */
/* @var $data Gig */
?>

<div class="view">

    <div class="image">
        <?php
        $imghtml = CHtml::image($data->getMainImage());
        echo CHtml::link($imghtml, array('view', 'id' => $data->id));
        ?>
    </div>

    <div class="description">
        <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id' => $data->id)); ?>
        <?php echo $data->venue->name ? '@' : ''; ?>
        <?php echo CHtml::link(CHtml::encode($data->venue->name), array('venue/view', 'id' => $data->venue->id)); ?>
        <br/>

        <?php echo CHtml::encode($data->getAttributeLabel('datetime_from')); ?>:
        <?php echo CHtml::encode(date('d.m.Y', strtotime($data->datetime_from))); ?>
        <br/>
        <?php echo CHtml::encode($data->getAttributeLabel('datetime_to')); ?>:
        <?php echo CHtml::encode(date('d.m.Y', strtotime($data->datetime_to))); ?>
        <br/>

        <?php echo CHtml::encode($data->getAttributeLabel('ds_type')); ?>:
        <?php echo $data->getDataProvider(); ?>
        <br/>
    </div>

    <div class="clear"></div>

</div>