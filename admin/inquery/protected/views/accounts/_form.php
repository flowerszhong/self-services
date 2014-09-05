<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'net_id'); ?>
		<?php echo $form->textField($model,'net_id',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'net_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'net_pwd'); ?>
		<?php echo $form->textField($model,'net_pwd',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'net_pwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id'); ?>
		<?php echo $form->error($model,'student_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grade'); ?>
		<?php echo $form->textField($model,'grade'); ?>
		<?php echo $form->error($model,'grade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'used'); ?>
		<?php echo $form->textField($model,'used'); ?>
		<?php echo $form->error($model,'used'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'available'); ?>
		<?php echo $form->textField($model,'available'); ?>
		<?php echo $form->error($model,'available'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'import_date'); ?>
		<?php echo $form->textField($model,'import_date'); ?>
		<?php echo $form->error($model,'import_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php echo $form->textField($model,'end_date'); ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->