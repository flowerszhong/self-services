<?php
/* @var $this NoticeController */
/* @var $model Notice */

$this->menu = array(
	array('label' => '通知列表', 'url' => array('index')),
	array('label' => '管理通知', 'url' => array('admin')),
);
?>
<h3 class="title">发新通知</h3>
<?php $this->renderPartial('_form', array('model' => $model));?>