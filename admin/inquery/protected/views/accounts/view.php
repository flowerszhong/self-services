<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Accounts', 'url'=>array('index')),
	array('label'=>'Create Accounts', 'url'=>array('create')),
	array('label'=>'Update Accounts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Accounts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accounts', 'url'=>array('admin')),
);
?>

<h1>View Accounts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'net_id',
		'net_pwd',
		'student_id',
		'user_name',
		'grade',
		'user_id',
		'used',
		'available',
		'import_date',
		'start_date',
		'end_date',
	),
)); ?>
