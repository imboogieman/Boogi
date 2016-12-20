<?php
/* @var $this VenueController */
/* @var $data Venue */
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
        <br/>

        <?php echo CHtml::encode($data->country->name); ?>
        ,
        <?php echo CHtml::encode($data->city); ?>
        ,
        <?php echo CHtml::encode($data->address); ?>

    </div>

    <div class="clear"></div>

</div>