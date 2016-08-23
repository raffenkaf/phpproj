<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\models\Book;

class SiteController extends MyCoreController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	$connection = Yii::$app->getDb();
    	
    	$maxDownloadSql = "SELECT book.*
    			          FROM 
    			          (
    			              SELECT book_id, COUNT(*) AS counted 
    			              FROM user_book_interactions  
    			              WHERE download = 1 
    			              GROUP BY book_id
    			              ORDER BY counted DESC
    			              LIMIT 100
    			          ) as top_list 
    			          JOIN book 
    			              ON (top_list.book_id = book.id)
    			          WHERE book.blocked=0 
    			              AND book.examined=1
    			          ORDER BY top_list.counted DESC
    			          LIMIT 1";
    	$command = $connection->createCommand($maxDownloadSql);    	           
    	$result = $command->queryOne();
    	$maxDownloadModel = new Book($result);
    	
    	$maxViewId =      "SELECT book.*
    			          FROM
    			          (
    			              SELECT book_id, COUNT(*) AS counted
    			              FROM user_book_interactions
    			              WHERE view = 1
    			              GROUP BY book_id
    			              ORDER BY counted DESC
    			              LIMIT 100
    			          ) as top_list
    			          JOIN book
    			              ON (top_list.book_id = book.id)
    			          WHERE book.blocked=0
    			              AND book.examined=1
    			          ORDER BY top_list.counted DESC
    			          LIMIT 1";
    	$command = $connection->createCommand($maxViewId);
    	$result = $command->queryOne();
    	$maxViewModel = new Book($result);
        
    	return $this->render('index', [
    			'maxDownloadModel' => $maxDownloadModel,
    			'maxViewModel' => $maxViewModel
    	]);
    }
    
    public function actionThanks()
    {
    	$this->layout = 'mainWithoutHeader';
    	return $this->render('thanks');
    }    
}
