<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
	const SCENARIO_EDIT = 'edit';
	const SCENARIO_EDIT_PASS = 'editPass';
	
	const ROLE_USER = 10;
	const ROLE_ADMIN = 20;
	
	public $photo;
	public $password_repeat;
	public $new_password;
	public $new_password_repeat;
	public $old_password;
	private $auth_key;
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_DEFAULT] = ['login', 'password', 'password_repeat', 'name', 'nickname', 
				                              'birth_date', 'FIO_visibility', 'patronymic', 'photo'];
		$scenarios[self::SCENARIO_EDIT] = ['login', 'name', 'nickname', 'birth_date', 'FIO_visibility', 'patronymic', 'photo'];
		$scenarios[self::SCENARIO_EDIT_PASS] = ['new_password', 'new_password_repeat', 'old_password'];
		return $scenarios;
	}
	
	public static function tableName()
	{
		return 'user';
	}
	
	public function beforeSave($insert)
	{
	
        if ($this->isNewRecord) {
            $this->password_repeat = $this->password //Pass already checked 
                = \Yii::$app->security->generatePasswordHash($this->password);	
        } else {
        	$this->password_repeat = $this->password;
        }
        
		if (parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				$this->auth_key = \Yii::$app->security->generateRandomString();
			}
			return true;
		}
		return false;
	}
	
	public function rules()
	{
		return [
				[['login', 'password', 'password_repeat', 'name', 'nickname', 'new_password', 'new_password_repeat', 'old_password'], 
						'required', 'message' => 'Данное поле являеться обязательным'],
				[['password', 'new_password'], 'string', 'min' => 6],
				['login', 'unique'],
				['birth_date', 'date', 'message' => 'Это поле является датой', 'format' => 'yyyy-MM-dd'],
				['photo', 'image', 'extensions' => 'png, jpg, gif', 'maxSize' => 10*1024*1024],
				[['last_name', 'patronymic', 'avatar_path'], 'string'],
				['FIO_visibility', 'boolean'],
			    ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают"],
				['new_password_repeat', 'compare', 'compareAttribute'=>'new_password', 'message'=>"Пароли не совпадают"]
		];
	}
	
	public function upload()
	{
		if (!isset($this->photo)) {
			return true;
		}
		$dir =  'uploads/img/users/'. $this->getAttribute('id');
		if ($this->validate()) {
			if (file_exists($dir)) {// Check if file exists ->
				$files = scandir($dir);// get all folder files ->
				foreach ($files as $file) { //delete files if it is not "." or ".."(delete user photo)
					if ($file != "." && $file != "..") {
						unlink($dir."/".$file);
					}
				}/////////////////////////////////////////////////////////////////////////////////////
			} else {
				mkdir($dir, 0777, true);
			}
			$this->photo->saveAs($dir. '/'. $this->photo->baseName . '.' . $this->photo->extension);
			$this->avatar_path = $dir. '/'. $this->photo->baseName . '.' . $this->photo->extension;
			$this->photo = null;
			if (!$this->save()) {
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|integer $id the ID to be looked for
	 * @return IdentityInterface|null the identity object that matches the given ID.
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}
	
	/**
	 * Finds an identity by the given token.
	 *
	 * @param string $token the token to be looked for
	 * @return IdentityInterface|null the identity object that matches the given token.
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}
	
	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return string current user auth key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}
	
	/**
	 * @param string $authKey
	 * @return boolean if auth key is valid for current user
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}
	
	public function validatePassword($password)
	{
		return Yii::$app->getSecurity()->validatePassword($password, $this->password);
	}
	
	public function attributeLabels()
	{
		return [
				'id' => 'ID',
				'login' => 'Логин',
				'password' => 'Пароль',
				'password_repeat' => 'Подтверждение пароля',
				'name' => 'Имя',
				'last_name' => 'Фамилия',
				'patronymic' => 'Отчество',
				'FIO_visibility' => 'Видимость ФИО',
				'nickname' => 'Ваш псевдоним',
				'birth_date' => 'Дата рождения',
				'photo' => 'Фото',
				'exemined' => 'Проверено',
				'blocked' => 'Блокировано',
				'created_at' => 'Создано',
				'new_password' => 'Новый пароль',
				'new_password_repeat' => 'Подтверждение нового пароля', 
				'old_password' => 'Текущий пароль'
		];
	}
}