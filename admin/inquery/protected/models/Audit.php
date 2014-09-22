<?php

/**
 * This is the model class for table "audit".
 *
 * The followings are the available columns in table 'audit':
 * @property string $id
 * @property string $filename
 * @property string $student_id
 * @property string $user_name
 * @property string $fee
 * @property string $comment
 * @property string $student_id_msg
 * @property string $student_id_ok
 * @property string $user_name_msg
 * @property string $user_name_ok
 * @property string $fee_msg
 * @property string $fee_ok
 * @property string $comment_msg
 * @property string $comment_ok
 */
class Audit extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'audit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('filename', 'length', 'max' => 200),
			array('student_id', 'length', 'max' => 40),
			array('user_name', 'length', 'max' => 60),
			array('fee, student_id_ok, user_name_ok, fee_ok, comment_ok', 'length', 'max' => 11),
			array('comment, student_id_msg, user_name_msg, fee_msg, comment_msg', 'length', 'max' => 100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, filename, student_id, user_name, fee, comment, student_id_msg, student_id_ok, user_name_msg, user_name_ok, fee_msg, fee_ok, comment_msg, comment_ok', 'safe', 'on' => 'search'),
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
			'id'             => 'ID',
			'filename'       => '班级缴费表',
			'student_id'     => '学号',
			'user_name'      => '姓名',
			'fee'            => '缴费金额',
			'comment'        => '开户或续费',
			'student_id_msg' => '是否注册',
			'student_id_ok'  => '是否注册代码',
			'user_name_msg'  => '姓名是否正确',
			'user_name_ok'   => '姓名确认码',
			'fee_msg'        => '金额',
			'fee_ok'         => 'Fee Ok',
			'comment_msg'    => '开户/续费是否正确',
			'comment_ok'     => '开户/续费确认码',
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
		$criteria->compare('filename', $this->filename, true);
		$criteria->compare('student_id', $this->student_id, true);
		$criteria->compare('user_name', $this->user_name, true);
		$criteria->compare('fee', $this->fee, true);
		$criteria->compare('comment', $this->comment, true);
		$criteria->compare('student_id_msg', $this->student_id_msg, true);
		$criteria->compare('student_id_ok', $this->student_id_ok, true);
		$criteria->compare('user_name_msg', $this->user_name_msg, true);
		$criteria->compare('user_name_ok', $this->user_name_ok, true);
		$criteria->compare('fee_msg', $this->fee_msg, true);
		$criteria->compare('fee_ok', $this->fee_ok, true);
		$criteria->compare('comment_msg', $this->comment_msg, true);
		$criteria->compare('comment_ok', $this->comment_ok, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Audit the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
