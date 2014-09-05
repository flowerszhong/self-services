<?php
/* @var $this AccountsController */
/* @var $data Accounts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_id')); ?>:</b>
	<?php echo CHtml::encode($data->net_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_pwd')); ?>:</b>
	<?php echo CHtml::encode($data->net_pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade')); ?>:</b>
	<?php echo CHtml::encode($data->grade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('used')); ?>:</b>
	<?php echo CHtml::encode($data->used); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('available')); ?>:</b>
	<?php echo CHtml::encode($data->available); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('import_date')); ?>:</b>
	<?php echo CHtml::encode($data->import_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	*/ ?>

</div>