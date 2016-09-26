<?php
/* @var $this ArtistController */
/* @var $model Artist */

$this->breadcrumbs = array(
    'Artists' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Artist', 'url' => array('index')),
    array('label' => 'Manage Artist', 'url' => array('admin')),
);
?>

<h1>Create Artist</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>