<?php
/* @var $this MessageController */
/* @var $data Message */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('gig_id')); ?>:</b>
    <?php echo CHtml::encode($data->gig_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->type); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
    <?php echo CHtml::encode($data->message); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
    <?php echo CHtml::encode($data->timestamp); ?>
    <br/>


</div>