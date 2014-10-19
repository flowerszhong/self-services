<?php
/* @var $this NoticeController */
/* @var $model Notice */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'notice-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,
));?>
<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model);?>
<div class="row">
<?php echo $form->labelEx($model, 'title');?>
		<?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 200));?>
		<?php echo $form->error($model, 'title');?>
</div>

	<div class="row">
<?php echo $form->labelEx($model, 'content');?>
		<?php echo $form->textarea($model, 'content', array('id' => 'Post_content'));?>
		<?php echo $form->error($model, 'content');?>
</div>

	<div class="row">
<?php echo $form->labelEx($model, 'summary');?>
		<?php echo $form->textarea($model, 'summary', array("rows" => 10, 'cols' => 95));?>
		<?php echo $form->error($model, 'summary');?>
</div>







	<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');?>
</div>

<?php $this->endWidget();?>


<?php
$this->widget('ext.ueditor.Ueditor',
	array(
		'getId' => 'Post_content',

		'UEDITOR_HOME_URL' => "/",
		'options' => 'toolbars:[["fontfamily","fontsize",
                "forecolor","bold","italic","strikethrough","|",
"insertunorderedlist","insertorderedlist","blockquote","|",
"link","unlink","highlightcode","|","undo","redo","source"]],
                    wordCount:false,
                    elementPathEnabled:false,
                    imagePath:"/attachment/ueditor/",
                    initialContent:"",
                    ',
	));
?>


</div><!-- form -->