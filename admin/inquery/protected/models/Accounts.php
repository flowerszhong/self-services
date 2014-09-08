<?php

/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property string $id
 * @property string $net_id
 * @property string $net_pwd
 * @property integer $student_id
 * @property string $user_name
 * @property integer $grade
 * @property integer $user_id
 * @property integer $used
 * @property integer $available
 * @property string $import_date
 * @property string $start_date
 * @property string $end_date
 */
class Accounts extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, grade, user_id, used, available', 'numerical', 'integerOnly' => true),
			array('net_id', 'length', 'max' => 400),
			array('net_pwd, user_name', 'length', 'max' => 40),
			array('import_date, start_date, end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, net_id, net_pwd, student_id, user_name, grade, user_id, used, available, import_date, start_date, end_date', 'safe', 'on' => 'search'),
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
			'id'          => 'ID',
			'net_id'      => '账号',
			'net_pwd'     => '密码',
			'student_id'  => '学号',
			'user_name'   => '姓名',
			'grade'       => '年级',
			'user_id'     => '用户id',
			'used'        => '已分配',
			'available'   => '是否可用',
			'import_date' => '导入时间',
			'start_date'  => '开始时间',
			'end_date'    => '结束时间',
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
		$criteria->compare('net_id', $this->net_id, true);
		$criteria->compare('net_pwd', $this->net_pwd, true);
		$criteria->compare('student_id', $this->student_id);
		$criteria->compare('user_name', $this->user_name, true);
		$criteria->compare('grade', $this->grade);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('used', $this->used);
		$criteria->compare('available', $this->available);
		$criteria->compare('import_date', $this->import_date, true);
		$criteria->compare('start_date', $this->start_date, true);
		$criteria->compare('end_date', $this->end_date, true);

		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
			));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accounts the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
