<?php $this->beginContent('//layouts/index'); ?>
    <div class="span-20">
        <?php echo $content; ?>
    </div>
    <div class="span-6 last">
        <div id="sidebar">
            <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => 'Operations',
                ));
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $this->menu,
                    'htmlOptions' => array('class' => 'operations'),
                ));
                $this->endWidget();
            ?>
        </div>
    </div>
<?php $this->endContent(); ?>