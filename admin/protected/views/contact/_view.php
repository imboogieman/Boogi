<?php
/* @var $this ContactController */
/* @var $data Contact */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
    <?php echo CHtml::encode($data->message); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
    <?php echo CHtml::encode($data->timestamp); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('source')); ?>:</b>
    <?php echo CHtml::encode($data->source); ?>
    <br/>


</div>