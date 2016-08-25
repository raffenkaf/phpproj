<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\models\Book;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use app\models\UserBookInteractions;
use app\models\AuthorsBooks;

class BookController extends MyCoreController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
            	'ruleConfig' => [
            		'class' => AccessRule::className(),
            	],
                'only' => ['add', 'edit', 'block', 'unblock', 'searchBlocked', 'searchUnchecked', 'allow', 'viewRestricted'],
                'rules' => [
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_USER,
                            User::ROLE_ADMIN
                        ],
                    ],
                	[
                		'actions' => ['edit', 'block', 'unblock', 'searchBlocked', 'searchUnchecked', 'allow', 'viewRestricted'],
                		'allow' => true,
                		'roles' => [
                		    User::ROLE_ADMIN
                	    ],
                	],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                	'add' => ['get', 'post'],
                	'edit' => ['get', 'post'],
                	'download-register' => ['post'],
                	'*' => ['get'],
                ],
            ],
        ];
    }
    
    public function actionViewRestricted()
    {
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	$model = Book::find()
    	             ->where(['id' => $id])
    	             ->one();
    	if (is_null($model)) {
    		return $this->actionNoBook();
    	}
    	return $this->render('index', [
    			'model' => $model
    	]);
    }
    
    public function actionAllow()
    {
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	$model = Book::find()
    	             ->where(['id' => $id])
    	             ->one();
    	$model->scenario = Book::SCENARIO_EDIT_RIGHTS;
    	$model->examined = 1;
    	$model->update();
    	return $this->redirect(['/book/index', 'id' => $id]);
    }
    
    public function actionBlock()
    {
    	$id = Yii::$app->request->get('id');
    	$model = Book::find()
    	             ->where(['id' => $id])
    	             ->one();
    	$model->scenario = Book::SCENARIO_EDIT_RIGHTS;
    	$model->blocked = 1;
    	$model->examined = 1;
    	$model->update();
    	return $this->redirect(['/book/view-restricted', 'id' => $id]);
    }
    
    public function actionUnblock()
    {
    	$id = Yii::$app->request->get('id');
    	$model = Book::find()
    	             ->where(['id' => $id])
    	             ->one();
    	$model->scenario = Book::SCENARIO_EDIT_RIGHTS;    	             
    	$model->blocked = 0;
    	$model->update();
    	return $this->redirect(['book/view-restricted', 'id' => $id]);
    }
    
    public function actionSearch()
    {
    	$searchText = Yii::$app->request->get('search');
    	if (!is_null($searchText)) {
            $models = Book::find()
                          ->distinct()
                          ->filterWhere(['like', 'title', $searchText])
//                           ->orFilterWhere(['like', 'genre', $searchText])
//                           ->orFilterWhere(['like', 'description', $searchText])
                          ->andFilterWhere(['blocked' => 0])
                          ->andFilterWhere(['examined' => 1])
                          ->orderBy('published_date DESC')
                          ->limit(10)
                          ->all();
            return $this->render('search', [
            		'models' => $models            	
            ]);
    	}
    	 
    	return $this->goBack();
    }
    
    public function actionSearchBlocked()
    {
    	$searchText = Yii::$app->request->get('search');
    	if (!is_null($searchText)) {
    		$models = Book::find()
    		              ->distinct()
    		              ->filterWhere(['like', 'title', $searchText])
//     		              ->orFilterWhere(['like', 'genre', $searchText])
//     		              ->orFilterWhere(['like', 'description', $searchText])
    		              ->andFilterWhere(['blocked' => 1])
    		              ->orderBy('published_date DESC')
    		              ->limit(10)
    		              ->all();
    		return $this->render('searchRestricted', [
    				'models' => $models
    		]);
    	}
    
    	return $this->goBack();
    }
    
    public function actionSearchUnchecked()
    {
    	$searchText = Yii::$app->request->get('search');
    	if (!is_null($searchText)) {
    		
    		$models = Book::find()
    		              ->distinct()
    		              ->filterWhere(['like', 'title', $searchText])
//     		              ->orFilterWhere(['like', 'genre', $searchText])
//     		              ->orFilterWhere(['like', 'description', $searchText])
    		              ->andFilterWhere(['examined' => 0])
    		              ->orderBy('published_date DESC')
    		              ->limit(10)
    		              ->all();
    		
    		return $this->render('searchRestricted', [
    				'models' => $models
    		]);
    	}
    
    	return $this->goBack();
    }
    
    public function actionEdit()
    {
        $this->layout = 'mainWithoutHeader';
        $request = Yii::$app->request;
      	$id = $request->get('id');
        
    	$model = Book::find()
    	             ->where(['id' => $id])
    	             ->one();
    	$model->scenario = Book::SCENARIO_EDIT;
    	
        if ($model->load(Yii::$app->request->post())) {
        	$model->examined = 0;
    		$model->bookCover = UploadedFile::getInstance($model, 'bookCover');
    		$model->bookFile = UploadedFile::getInstance($model, 'bookFile');

    		$transaction = Book::getDb()->beginTransaction();
    		try {    			
    			if (!$model->save() 
    					|| !$model->uploadBookCover() 
    					|| !$model->uploadBookFile()
    					) {
                    throw (new \Exception);				
    			}
    			
    			foreach (Yii::$app->request->post('authorId') as $authorId) {
    				foreach ($model->authors as $author) {
    					if ($author->id == $authorId) {
    						continue 2;
    					}
    				}
    				$authorBookModel = new AuthorsBooks();
    				$authorBookModel->author_id = $authorId;
    				$authorBookModel->book_id = $model->id;    				
    				if (!$authorBookModel->save()) {
                        throw (new \Exception($authorId." ".$model->id));
    				}
    			}
    			
    			foreach ($model->authors as $author) {
    				
    			    foreach (Yii::$app->request->post('authorId') as $authorId) {
    					if ($author->id == $authorId) {
    						continue 2;
    					}
    				}
    				
    				$authorBookModel=AuthorsBooks::find()
    				                             ->filterWhere(['book_id'=>$model->id])
    				                             ->andFilterWhere(['author_id'=>$author->id])
    				                             ->one();
    				$authorBookModel->delete();
    			}
    			$transaction->commit();
    		} catch (\Exception $e) {
    			$transaction->rollBack();
    			return $this->render('add', [
    					'model' => $model,
    			]);
    		}
    		return $this->redirect(['/book/view-restricted', 'id' => $model->id]);
    	}
    	if (is_null($model)) {
    	    return $this->actionNoBook();
    	}
    	return $this->render('edit', [
    			'model' => $model
    	]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	$request = Yii::$app->request;
    	$id = $request->get('id');
     	$model = Book::find()
    	             ->where(['id' => $id, 'examined' => '1', 'blocked' => '0'])
     	             ->one();
     	if (is_null($model)) {
     		return $this->actionNoBook();
     	}
     	//saving 1 record to UserBookInteractions(mb this part should be in model?)
     	$ipAddress = Yii::$app->request->userIp;
     	$anyRecord = UserBookInteractions::find()
     	                                 ->where(['ip' => $ipAddress])
     	                                 ->andFilterWhere(['>', 'added', date('Y-m-d H:i:s', (time()- 86400))])
     	                                 ->andFilterWhere(['view' => 1])
     	                                 ->one();
     	if (is_null($anyRecord)) {
     		$userBookInteractionsModel = new UserBookInteractions();
     		$userBookInteractionsModel->ip = $ipAddress;
     		$userBookInteractionsModel->book_id = $id;
     		$userBookInteractionsModel->view = 1;
     		$userBookInteractionsModel->download = 0;
     		$userBookInteractionsModel->save();//if it did not save - it is not a big problem
     	}
     	//
     	return $this->render('index', [
    			'model' => $model
    	]);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionAdd()
    {
    	$this->layout = 'mainWithoutHeader';
    	$model = new Book();
    	if ($model->load(Yii::$app->request->post())) {
    		$model->created_at = date('Y-m-d H:i:s', time());
    		$model->added_by = Yii::$app->user->getIdentity()->id;
    		
    		$model->bookCover = UploadedFile::getInstance($model, 'bookCover');
    		$model->bookFile = UploadedFile::getInstance($model, 'bookFile');

    		$transaction = Book::getDb()->beginTransaction();
    		try {

    			if (!$model->save() 
    					|| !$model->uploadBookCover() 
    					|| !$model->uploadBookFile()
    					) {
                    throw (new \Exception);				
    			}
    			
    			foreach (Yii::$app->request->post('authorId') as $authorId) {
    				$authorBookModel = new AuthorsBooks();
    				$authorBookModel->author_id = $authorId;
    				$authorBookModel->book_id = $model->id;
    				if (!$authorBookModel->save()) {
                        throw (new \Exception($authorId." ".$model->id));
    				}
    			}
    			$transaction->commit();
    		} catch (\Exception $e) {

    			$transaction->rollBack();
    			return $this->render('add', [
    					'model' => $model,
    			]);
    		}
    		return $this->render('//site/thanks');
    	}
    	
    	return $this->render('add', [
            'model' => $model,
        ]);
    }
    
    public function actionNoBook()
    {
    	$this->layout = 'mainWithoutHeader';
    	return $this->render('noBook');
    }
// Ajax function for register new download    
    public function actionDownloadRegister()
    {
    	if(!empty($_POST["id"])) {
    		$ipAddress = Yii::$app->request->userIp;
    		$anyRecord = UserBookInteractions::find()
    		                                 ->where(['ip' => $ipAddress])
    		                                 ->andFilterWhere(['>', 'added', date('Y-m-d H:i:s', (time()- 86400))])
    		                                 ->andFilterWhere(['download' => 1])
    		                                 ->one();
   		
    		if (is_null($anyRecord)) {
    			$userBookInteractionsModel = new UserBookInteractions();
    			$userBookInteractionsModel->ip = $ipAddress;
    			$userBookInteractionsModel->book_id = $_POST["id"];
    			$userBookInteractionsModel->view = 0;
    			$userBookInteractionsModel->download = 1;
    			$userBookInteractionsModel->save();
    		}

    	}

    }
//    
}
