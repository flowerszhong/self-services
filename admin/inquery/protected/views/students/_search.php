<?php
/* @var $this StudentsController */
/* @var $model Students */
/* @var $form CActiveForm */
?>
<div class="wide form">

<?php $form = $this->beginWidget('CActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
	));?>
<div class="row">
<?php echo $form->label($model, 'id');?>
		<?php echo $form->textField($model, 'id', array('size' => 40, 'maxlength' => 40));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'student_id');?>
		<?php echo $form->textField($model, 'student_id');?>
</div>

	<div class="row">
<?php echo $form->label($model, 'user_name');?>
		<?php echo $form->textField($model, 'user_name', array('size' => 40, 'maxlength' => 40));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'user_email');?>
		<?php echo $form->textField($model, 'user_email', array('size' => 60, 'maxlength' => 100));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'pwd');?>
		<?php echo $form->textField($model, 'pwd', array('size' => 60, 'maxlength' => 220));?>
</div>


	<div class="row">
<?php echo $form->label($model, 'tel');?>
		<?php echo $form->textField($model, 'tel', array('size' => 20, 'maxlength' => 20));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'qq');?>
		<?php echo $form->textField($model, 'qq');?>
</div>

	<div class="row">
<?php echo $form->label($model, 'department');?>
		<?php echo $form->textField($model, 'department', array('size' => 40, 'maxlength' => 40));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'major');?>
		<?php echo $form->textField($model, 'major', array('size' => 40, 'maxlength' => 40));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'sub_major');?>
		<?php echo $form->textField($model, 'sub_major', array('size' => 50, 'maxlength' => 50));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'grade');?>
		<?php echo $form->textField($model, 'grade');?>
</div>

	<div class="row">
<?php echo $form->label($model, 'class');?>
		<?php echo $form->textField($model, 'class');?>
</div>


	<div class="row">
<?php echo $form->label($model, 'approved');?>
		<?php echo $form->textField($model, 'approved');?>
</div>



	<div class="row">
<?php echo $form->label($model, 'banned');?>
		<?php echo $form->textField($model, 'banned');?>
</div>

	<div class="row">
<?php echo $form->label($model, 'net_id');?>
		<?php echo $form->textField($model, 'net_id', array('size' => 60, 'maxlength' => 400));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'net_pwd');?>
		<?php echo $form->textField($model, 'net_pwd', array('size' => 40, 'maxlength' => 40));?>
</div>

	<div class="row">
<?php echo $form->label($model, 'start_date');?>
		<?php echo $form->textField($model, 'start_date');?>
</div>

	<div class="row">
<?php echo $form->label($model, 'expire_date');?>
		<?php echo $form->textField($model, 'expire_date');?>
</div>

	<div class="row buttons">
<?php echo CHtml::submitButton('Search');?>
</div>

<?php $this->endWidget();?>

</div><!-- search-form -->