<?php

/**
 * This is the model class for table "students".
 *
 * The followings are the available columns in table 'students':
 * @property string $id
 * @property integer $student_id
 * @property string $user_name
 * @property string $user_email
 * @property string $pwd
 * @property string $md5_id
 * @property string $tel
 * @property integer $qq
 * @property string $department
 * @property string $major
 * @property string $sub_major
 * @property integer $grade
 * @property integer $class
 * @property string $log_ip
 * @property integer $approved
 * @property string $reg_date
 * @property integer $activation_code
 * @property integer $banned
 * @property string $ckey
 * @property integer $ctime
 * @property string $net_id
 * @property string $net_pwd
 * @property string $start_date
 * @property string $expire_date
 */
class Students extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'students';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id', 'required'),
			array('student_id, qq, grade, class, approved, activation_code, banned, ctime', 'numerical', 'integerOnly' => true),
			array('user_name, department, major, log_ip, net_pwd', 'length', 'max' => 40),
			array('user_email, ckey', 'length', 'max' => 100),
			array('pwd', 'length', 'max' => 220),
			array('md5_id', 'length', 'max' => 200),
			array('tel', 'length', 'max' => 20),
			array('sub_major', 'length', 'max' => 50),
			array('net_id', 'length', 'max' => 400),
			array('reg_date, start_date, expire_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, student_id, user_name, user_email, tel, qq, department, major, sub_major, grade, class, log_ip, approved, reg_date, activation_code, banned, ckey, ctime, net_id, net_pwd, start_date, expire_date', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'              => 'ID',
			'student_id'      => '学号',
			'user_name'       => '姓名',
			'user_email'      => '邮箱',
			'pwd'             => '密码',
			'md5_id'          => 'Md5',
			'tel'             => '电话',
			'qq'              => 'QQ',
			'department'      => '系',
			'major'           => '专业',
			'sub_major'       => '专业方向',
			'grade'           => '年级',
			'class'           => '班级',
			'log_ip'          => '登录IP',
			'approved'        => '通过验证',
			'reg_date'        => '注册日期',
			'activation_code' => '激活码',
			'banned'          => '禁止使用',
			'ckey'            => 'Ckey',
			'ctime'           => 'Ctime',
			'net_id'          => '上网账号号',
			'net_pwd'         => '上网密码',
			'start_date'      => '开始时间',
			'expire_date'     => '结束时间',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('student_id', $this->student_id);
		$criteria->compare('user_name', $this->user_name, true);
		$criteria->compare('user_email', $this->user_email, true);
		$criteria->compare('pwd', $this->pwd, true);
		// $criteria->compare('md5_id', $this->md5_id, true);
		$criteria->compare('tel', $this->tel, true);
		$criteria->compare('qq', $this->qq);
		$criteria->compare('department', $this->department, true);
		$criteria->compare('major', $this->major, true);
		$criteria->compare('sub_major', $this->sub_major, true);
		$criteria->compare('grade', $this->grade);
		$criteria->compare('class', $this->class);
		$criteria->compare('log_ip', $this->log_ip, true);
		$criteria->compare('approved', $this->approved);
		$criteria->compare('reg_date', $this->reg_date, true);
		$criteria->compare('activation_code', $this->activation_code);
		$criteria->compare('banned', $this->banned);
		$criteria->compare('ckey', $this->ckey, true);
		$criteria->compare('ctime', $this->ctime);
		$criteria->compare('net_id', $this->net_id, true);
		$criteria->compare('net_pwd', $this->net_pwd, true);
		// $criteria->compare('start_date', CDateTimeParser::parse($this->start_date, 'yyyy-mm-dd'), true);
		$criteria->compare('start_date', $this->start_date, true);
		$criteria->compare('expire_date', $this->expire_date, true);
		// $criteria->compare('expire_date', $this->expire_date, true);

		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
			));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Students the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
