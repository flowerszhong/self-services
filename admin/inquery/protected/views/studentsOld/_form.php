<?php
/* @var $this StudentsOldController */
/* @var $model StudentsOld */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'students-old-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel'); ?>
		<?php echo $form->textField($model,'tel',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'major'); ?>
		<?php echo $form->textField($model,'major',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'major'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grade'); ?>
		<?php echo $form->textField($model,'grade'); ?>
		<?php echo $form->error($model,'grade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class'); ?>
		<?php echo $form->textField($model,'class'); ?>
		<?php echo $form->error($model,'class'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'net_id'); ?>
		<?php echo $form->textField($model,'net_id',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'net_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'net_pwd'); ?>
		<?php echo $form->textField($model,'net_pwd',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'net_pwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fee'); ?>
		<?php echo $form->textField($model,'fee'); ?>
		<?php echo $form->error($model,'fee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pay_date'); ?>
		<?php echo $form->textField($model,'pay_date'); ?>
		<?php echo $form->error($model,'pay_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expire_date'); ?>
		<?php echo $form->textField($model,'expire_date'); ?>
		<?php echo $form->error($model,'expire_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->