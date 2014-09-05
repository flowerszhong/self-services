<?php
/* @var $this StudentsController */
/* @var $data Students */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_email')); ?>:</b>
	<?php echo CHtml::encode($data->user_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pwd')); ?>:</b>
	<?php echo CHtml::encode($data->pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('md5_id')); ?>:</b>
	<?php echo CHtml::encode($data->md5_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel')); ?>:</b>
	<?php echo CHtml::encode($data->tel); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('qq')); ?>:</b>
	<?php echo CHtml::encode($data->qq); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('major')); ?>:</b>
	<?php echo CHtml::encode($data->major); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_major')); ?>:</b>
	<?php echo CHtml::encode($data->sub_major); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade')); ?>:</b>
	<?php echo CHtml::encode($data->grade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class')); ?>:</b>
	<?php echo CHtml::encode($data->class); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_ip')); ?>:</b>
	<?php echo CHtml::encode($data->log_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved')); ?>:</b>
	<?php echo CHtml::encode($data->approved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reg_date')); ?>:</b>
	<?php echo CHtml::encode($data->reg_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_code')); ?>:</b>
	<?php echo CHtml::encode($data->activation_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('banned')); ?>:</b>
	<?php echo CHtml::encode($data->banned); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ckey')); ?>:</b>
	<?php echo CHtml::encode($data->ckey); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctime')); ?>:</b>
	<?php echo CHtml::encode($data->ctime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_id')); ?>:</b>
	<?php echo CHtml::encode($data->net_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_pwd')); ?>:</b>
	<?php echo CHtml::encode($data->net_pwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expire_date')); ?>:</b>
	<?php echo CHtml::encode($data->expire_date); ?>
	<br />

	*/ ?>

</div>