<?php
/* @var $this AccountsController */
/* @var $data Accounts */
?>

<div class="view">



	<b><?php echo CHtml::encode($data->getAttributeLabel('net_id'));?>:</b>
<?php echo CHtml::encode($data->net_id);?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_pwd'));?>:</b>
<?php echo CHtml::encode($data->net_pwd);?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id'));?>:</b>
<?php echo CHtml::encode($data->student_id);?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name'));?>:</b>
<?php echo CHtml::encode($data->user_name);?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade'));?>:</b>
<?php echo CHtml::encode($data->grade);?>
<br />



<?php echo CHtml::encode($data->getAttributeLabel('used'));?>:</b>
<?php echo CHtml::encode($data->used);?>
<label>
	未被使用：0 ； 被使用：1 ； 被其它账号替换：2 ； 其它原因停用 ： 3 ；
</label>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('available'));?>:</b>
<?php echo CHtml::encode($data->available);?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('import_date'));?>:</b>
<?php echo CHtml::encode($data->import_date);?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('start_date'));?>:</b>
<?php echo CHtml::encode($data->start_date);?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('end_date'));?>:</b>
<?php echo CHtml::encode($data->end_date);?>
<br />


</div>