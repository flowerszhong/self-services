<?php
/* @var $this AuditController */
/* @var $model Audit */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'audit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'student_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fee'); ?>
		<?php echo $form->textField($model,'fee',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'fee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'student_id_msg'); ?>
		<?php echo $form->textField($model,'student_id_msg',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'student_id_msg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'student_id_ok'); ?>
		<?php echo $form->textField($model,'student_id_ok',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'student_id_ok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name_msg'); ?>
		<?php echo $form->textField($model,'user_name_msg',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_name_msg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name_ok'); ?>
		<?php echo $form->textField($model,'user_name_ok',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'user_name_ok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fee_msg'); ?>
		<?php echo $form->textField($model,'fee_msg',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'fee_msg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fee_ok'); ?>
		<?php echo $form->textField($model,'fee_ok',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'fee_ok'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_msg'); ?>
		<?php echo $form->textField($model,'comment_msg',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'comment_msg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_ok'); ?>
		<?php echo $form->textField($model,'comment_ok',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'comment_ok'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->