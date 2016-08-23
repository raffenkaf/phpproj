<?php

namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
	const SCENARIO_EDIT = 'edit';
	const SCENARIO_EDIT_RIGHTS = 'editRigths';
	
	public $bookCover;
	public $bookFile;
	public $authorIdFlag;
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_EDIT] = [
				                           'title', 'description', 'authorIdFlag', 'bookCover', 
				                           'book_cover_path', 'file_path', 'genre', 'added_by'
				                          ];
		$scenarios[self::SCENARIO_EDIT_RIGHTS] = [
				                           'title', 'description', 'bookCover', 
				                           'book_cover_path', 'file_path', 'genre', 'added_by'
				                          ];
		return $scenarios;
	}
	
	public function getAuthors()
	{
		return $this->hasMany(Author::className(), ['id' => 'author_id'])
		     ->viaTable('authors_books', ['book_id' => 'id']);
	}
	
	public static function tableName()
	{
		return 'book';
	}
	
	public function rules()
	{
		return [
				[['title', 'description', 'bookFile'], 'required', 'message' => 'Данное поле являеться обязательным'],
				['authorIdFlag', 'required', 'message' => 'Нужен как минимум 1 автор'],
				['published_date', 'date', 'message' => 'Это поле является датой', 'format' => 'yyyy'],
				['bookCover', 'image', 'extensions' => 'png, jpg, gif', 'maxSize' => 10*1024*1024],
				['bookFile', 'file', 'extensions' => ['fb2', 'epub', 'rtf', 'zip'], 'maxSize' => 100*1024*1024],
				[['book_cover_path', 'file_path', 'genre'], 'string'],
				['added_by', 'integer']
		];
	}
	
	public function uploadBookCover()
	{

		if (!isset($this->bookCover)) {
			return true;
		}

		$dir =  'uploads/img/books/'. $this->getAttribute('id');
		if ($this->validate()) {
			if (file_exists($dir)) {// Check if file exists ->
				$files = scandir($dir);// get all folder files ->
				foreach ($files as $file) { //delete files if it is not "." or ".."
					if ($file != "." && $file != "..") {
						unlink($dir."/".$file);
					}
				}//////////////////////////////////////////////////////////////////
			} else {
				mkdir($dir, 0777, true);
			}
			$this->bookCover->saveAs($dir. '/'. $this->bookCover->baseName . '.' . $this->bookCover->extension);
			$this->book_cover_path = $dir. '/'. $this->bookCover->baseName . '.' . $this->bookCover->extension;
			$this->bookCover=null;
			if (!$this->save()) {
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
	
	public function uploadBookFile()
	{
		if (!isset($this->bookFile)) {
			return true;
		}
		
		$dir =  'uploads/bookFiles/'. $this->getAttribute('id');
		if ($this->validate()) {
			if (file_exists($dir)) {// Check if file exists ->
				$files = scandir($dir);// get all folder files ->
				foreach ($files as $file) { //delete files if it is not "." or ".."
					if ($file != "." && $file != "..") {
						unlink($dir."/".$file);
					}
				}//////////////////////////////////////////////////////////////////
			} else {
				mkdir($dir, 0777, true);
			}
			
			$this->bookFile->saveAs($dir. '/'. $this->bookFile->baseName . '.' . $this->bookFile->extension);
			$this->file_path = $dir. '/'. $this->bookFile->baseName . '.' . $this->bookFile->extension;
			$this->bookFile = null;
			if (!$this->save(false)) {
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
				'title' => 'Название книги',
				'published_date' => 'Дата издания',
				'genre' => 'Жанр(или жанры)',
				'bookCover' => 'Обложка',
				'bookFile' => 'Книга(fb2, rtf, epub, zip)',
				'description' => 'Описание',				
				'exemined' => 'Проверено',
				'blocked' => 'Блокировано',
				'created_at' => 'Создано'
		];
	}
}