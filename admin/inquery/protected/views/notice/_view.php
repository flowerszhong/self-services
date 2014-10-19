<?php
/* @var $this NoticeController */
/* @var $data Notice */
?>
<div class="view">
<?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id' => $data->id));?>
<span class="update-date" style="float:right;">
<?php echo CHtml::encode($data->create_time);?>
</span>


</div>