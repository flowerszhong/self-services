<div class="notice-page">
<?php
/* @var $this NoticeController */
/* @var $dataProvider CActiveDataProvider */

$this->menu = array(
	array('label' => '发新通知', 'url' => array('create')),
	array('label' => '管理通知', 'url' => array('admin')),
);

?>
<h3 class="title">通知列表</h3>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
));?>
</div>

