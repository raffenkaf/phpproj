<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{	
	public $photo;
	
	const SCENARIO_EDIT_RIGHTS = 'editRigths';
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_EDIT_RIGHTS] = ['name', 'birth_date', 'biography', 'birth_date'];
		return $scenarios;
	}
	
	public function getBooks()
	{
		return $this->hasMany(Book::className(), ['id' => 'book_id'])
		    ->viaTable('authors_books', ['author_id' => 'id']);
	}
	
	public static function tableName()
	{
		return 'author';
	}
	
	public function rules()
	{
		return [
			// атрибут required указывает, что поля обязательны для заполнения
			[['name', 'birth_date', 'biography'], 'required', 'message' => 'Данное поле являеться обязательным'],
			['birth_date', 'date', 'message' => 'Это поле является датой', 'format' => 'yyyy-MM-dd'],
			['photo', 'image', 'extensions' => 'png, jpg, gif', 'maxSize' => 10*1024*1024],
			['photo_path', 'string']
		];
	}
	
	public function upload()
	{
		if (!isset($this->photo)) {
			return true;
		}
		$dir =  'uploads/img/authors/'. $this->getAttribute('id');
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
			$this->photo_path = $dir. '/'. $this->photo->baseName . '.' . $this->photo->extension;
			$this->photo = null;
            if (!$this->save()) {
            	return false;
            }
			return true;
		} else {
			return false;
		}
	}
	
	public function attributeLabels()
	{
		return [
				'id' => 'ID',
				'name' => 'Имя',
				'birth_date' => 'Дата рождения',
				'biography' => 'Биография',
				'photo' => 'Фото автора',				
				'exemined' => 'Проверено',
				'blocked' => 'Блокировано',
				'created_at' => 'Создано'
		];
	}
	
}
