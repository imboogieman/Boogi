<?php
/* @var $this PromoterController */
/* @var $data Promoter */
?>

<div class="view">

    <div class="image">
        <?php
        $img = CHtml::image($data->getMainImage());
        echo CHtml::link($img, array('view', 'id' => $data->id));
        ?>
    </div>

    <div class="description">

        <?php
            $name = CHtml::encode($data->name);
            echo CHtml::link($name, array('view', 'id' => $data->id));
        ?>
        <br/>

        <?php echo CHtml::encode($data->description); ?>
        <br/>

    </div>

    <div class="clear"></div>
</div>