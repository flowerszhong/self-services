<?php
/* @var $this StudentsOldController */
/* @var $model StudentsOld */

$this->breadcrumbs=array(
	'Students Olds'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StudentsOld', 'url'=>array('index')),
	array('label'=>'Create StudentsOld', 'url'=>array('create')),
	array('label'=>'View StudentsOld', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StudentsOld', 'url'=>array('admin')),
);
?>

<h1>Update StudentsOld <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>