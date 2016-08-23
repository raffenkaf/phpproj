<?php

namespace app\models;

/**
 * This is the model class for table "user_book_interactions".
 *
 * @property integer $id
 * @property string $ip
 * @property integer $book_id
 * @property integer $view
 * @property integer $download
 *
 * @property Book $book
 */
class UserBookInteractions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_book_interactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'view', 'download'], 'integer'],
            [['ip'], 'string', 'max' => 20],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'book_id' => 'Book ID',
            'view' => 'Просмотрели',
            'download' => 'Скачали',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
}
