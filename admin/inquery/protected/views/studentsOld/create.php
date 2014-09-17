<?php
/* @var $this StudentsOldController */
/* @var $model StudentsOld */

$this->breadcrumbs=array(
	'Students Olds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StudentsOld', 'url'=>array('index')),
	array('label'=>'Manage StudentsOld', 'url'=>array('admin')),
);
?>

<h1>Create StudentsOld</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>