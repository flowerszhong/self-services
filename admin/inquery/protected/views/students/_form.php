<?php
/* @var $this StudentsController */
/* @var $model Students */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'students-form',
// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,
));?>
<p class="note">星号<span class="required">*</span>为必填项</p>

<?php echo $form->errorSummary($model);?>
<div class="row">
<?php echo $form->labelEx($model, 'student_id');?>
<?php echo $form->textField($model, 'student_id');?>
<?php echo $form->error($model, 'student_id');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'user_name');?>
<?php echo $form->textField($model, 'user_name', array('size' => 40, 'maxlength' => 40));?>
<?php echo $form->error($model, 'user_name');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'user_email');?>
<?php echo $form->textField($model, 'user_email', array('size' => 60, 'maxlength' => 100));?>
<?php echo $form->error($model, 'user_email');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'pwd');?>
<?php echo $form->textField($model, 'pwd', array('size' => 60, 'maxlength' => 220));?>
<?php echo $form->error($model, 'pwd');?>
</div>


<div class="row">
<?php echo $form->labelEx($model, 'tel');?>
<?php echo $form->textField($model, 'tel', array('size' => 20, 'maxlength' => 20));?>
<?php echo $form->error($model, 'tel');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'qq');?>
<?php echo $form->textField($model, 'qq');?>
<?php echo $form->error($model, 'qq');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'department');?>
<?php echo $form->textField($model, 'department', array('size' => 40, 'maxlength' => 40));?>
<?php echo $form->error($model, 'department');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'major');?>
<?php echo $form->textField($model, 'major', array('size' => 40, 'maxlength' => 40));?>
<?php echo $form->error($model, 'major');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'sub_major');?>
<?php echo $form->textField($model, 'sub_major', array('size' => 50, 'maxlength' => 50));?>
<?php echo $form->error($model, 'sub_major');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'grade');?>
<?php echo $form->textField($model, 'grade');?>
<?php echo $form->error($model, 'grade');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'class');?>
<?php echo $form->textField($model, 'class');?>
<?php echo $form->error($model, 'class');?>
</div>



<div class="row">
<?php echo $form->labelEx($model, 'approved');?>
<?php echo $form->textField($model, 'approved');?>
<?php echo $form->error($model, 'approved');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'reg_date');?>
<?php echo $form->textField($model, 'reg_date');?>
<?php echo $form->error($model, 'reg_date');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'activation_code');?>
<?php echo $form->textField($model, 'activation_code');?>
<?php echo $form->error($model, 'activation_code');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'banned');?>
<?php echo $form->textField($model, 'banned');?>
<?php echo $form->error($model, 'banned');?>
</div>



<div class="row">
<?php echo $form->labelEx($model, 'net_id');?>
<?php echo $form->textField($model, 'net_id', array('size' => 60, 'maxlength' => 400));?>
<?php echo $form->error($model, 'net_id');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'net_pwd');?>
<?php echo $form->textField($model, 'net_pwd', array('size' => 40, 'maxlength' => 40));?>
<?php echo $form->error($model, 'net_pwd');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'start_date');?>
<?php echo $form->textField($model, 'start_date');?>
<?php echo $form->error($model, 'start_date');?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'expire_date');?>
<?php echo $form->textField($model, 'expire_date');?>
<?php echo $form->error($model, 'expire_date');?>
</div>

<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');?>
</div>

<?php $this->endWidget();?>

</div><!-- form -->