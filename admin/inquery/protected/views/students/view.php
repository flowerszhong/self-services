<a href="index.php?r=students/admin">返回</a>


<?php $this->widget('zii.widgets.CDetailView', array(
		'data'       => $model,
		'attributes' => array(
			// 'id',
			'student_id',
			'user_name',
			'user_email',
			'pwd',
			'md5_id',
			'tel',
			'qq',
			'department',
			'major',
			'sub_major',
			'grade',
			'class',
			// 'log_ip',
			'approved',
			'reg_date',
			'activation_code',
			'banned',
			// 'ckey',
			// 'ctime',
			'net_id',
			'net_pwd',
			'start_date',
			'expire_date',
			'pay_date',
		),
	));?>
