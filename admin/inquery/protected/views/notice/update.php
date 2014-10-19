<?php
/* @var $this NoticeController */
/* @var $model Notice */

$this->menu = array(
	array('label' => '通知列表', 'url' => array('index')),
	array('label' => '发新通知', 'url' => array('create')),
	array('label' => '查看该通知', 'url' => array('view', 'id' => $model->id)),
	array('label' => '管理通知', 'url' => array('admin')),
);
?>
<h3 class="title">更新通知</h3>

<?php $this->renderPartial('_form', array('model' => $model));?>