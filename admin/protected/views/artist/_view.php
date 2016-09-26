<?php
/* @var $this ArtistController */
/* @var $data Artist */
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

        <?php echo CHtml::encode($data->description); ?>
        <br/>

        <?php
        echo CHtml::image('/images/i-gig.png');
        echo ' ' . count($data->artistGigs);
        echo CHtml::image('/images/i-promoter.png');
        echo ' ' . count($data->artistPromoters);
        ?>

    </div>

    <div class="clear"></div>
</div>
