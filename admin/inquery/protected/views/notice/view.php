<?php
/* @var $this NoticeController */
/* @var $model Notice */

$this->menu = array(
	array('label' => '通知列表', 'url' => array('index')),
	array('label' => '发新通知', 'url' => array('create')),
	array('label' => '更新该通知', 'url' => array('update', 'id' => $model->id)),
	array('label' => '删除该通知', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => '管理通知', 'url' => array('admin')),
);
?>
<h3 class="title">
<?php
echo $model->title;
?>
</h3>

<div>
<?php
echo $model->update_time;
echo "<br>";
echo "<br>";
echo $model->content;
?>
</div>

