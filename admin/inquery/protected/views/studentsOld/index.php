<?php
/* @var $this StudentsOldController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Students Olds',
);

$this->menu=array(
	array('label'=>'Create StudentsOld', 'url'=>array('create')),
	array('label'=>'Manage StudentsOld', 'url'=>array('admin')),
);
?>

<h1>Students Olds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
