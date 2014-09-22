<?php
/* @var $this AuditController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Audits',
);

$this->menu=array(
	array('label'=>'Create Audit', 'url'=>array('create')),
	array('label'=>'Manage Audit', 'url'=>array('admin')),
);
?>

<h1>Audits</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
