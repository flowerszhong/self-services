<?php
/* @var $this StudentsOldController */
/* @var $model StudentsOld */

$this->breadcrumbs=array(
	'Students Olds'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List StudentsOld', 'url'=>array('index')),
	array('label'=>'Create StudentsOld', 'url'=>array('create')),
	array('label'=>'Update StudentsOld', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StudentsOld', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StudentsOld', 'url'=>array('admin')),
);
?>

<h1>View StudentsOld #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'tel',
		'major',
		'grade',
		'class',
		'net_id',
		'net_pwd',
		'fee',
		'pay_date',
		'expire_date',
	),
)); ?>
