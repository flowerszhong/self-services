<?php

/**
 * This is the model class for table "students2013".
 *
 * The followings are the available columns in table 'students2013':
 * @property string $id
 * @property string $name
 * @property string $tel
 * @property string $major
 * @property integer $grade
 * @property integer $class
 * @property string $net_id
 * @property string $net_pwd
 * @property integer $fee
 * @property string $pay_date
 * @property string $expire_date
 */
class StudentsOld extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'students2013';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('grade, class, fee', 'numerical', 'integerOnly'=>true),
			array('name, tel', 'length', 'max'=>40),
			array('major, net_pwd', 'length', 'max'=>100),
			array('net_id', 'length', 'max'=>400),
			array('pay_date, expire_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, tel, major, grade, class, net_id, net_pwd, fee, pay_date, expire_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'tel' => 'Tel',
			'major' => 'Major',
			'grade' => 'Grade',
			'class' => 'Class',
			'net_id' => 'Net',
			'net_pwd' => 'Net Pwd',
			'fee' => 'Fee',
			'pay_date' => 'Pay Date',
			'expire_date' => 'Expire Date',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('major',$this->major,true);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('class',$this->class);
		$criteria->compare('net_id',$this->net_id,true);
		$criteria->compare('net_pwd',$this->net_pwd,true);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('pay_date',$this->pay_date,true);
		$criteria->compare('expire_date',$this->expire_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StudentsOld the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
