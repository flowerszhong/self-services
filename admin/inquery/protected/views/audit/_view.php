<?php
/* @var $this AuditController */
/* @var $data Audit */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fee')); ?>:</b>
	<?php echo CHtml::encode($data->fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id_msg')); ?>:</b>
	<?php echo CHtml::encode($data->student_id_msg); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id_ok')); ?>:</b>
	<?php echo CHtml::encode($data->student_id_ok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name_msg')); ?>:</b>
	<?php echo CHtml::encode($data->user_name_msg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name_ok')); ?>:</b>
	<?php echo CHtml::encode($data->user_name_ok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fee_msg')); ?>:</b>
	<?php echo CHtml::encode($data->fee_msg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fee_ok')); ?>:</b>
	<?php echo CHtml::encode($data->fee_ok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_msg')); ?>:</b>
	<?php echo CHtml::encode($data->comment_msg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_ok')); ?>:</b>
	<?php echo CHtml::encode($data->comment_ok); ?>
	<br />

	*/ ?>

</div>