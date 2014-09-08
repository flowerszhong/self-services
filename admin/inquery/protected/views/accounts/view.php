<a href="index.php?r=accounts/admin">返回</a>

<?php $this->widget('zii.widgets.CDetailView', array(
		'data'       => $model,
		'attributes' => array(
			// 'id',
			'net_id',
			'net_pwd',
			'student_id',
			'user_name',
			'grade',
			// 'user_id',
			'used',
			'available',
			'start_date',
			'end_date',
			'import_date',
		),
	));?>
