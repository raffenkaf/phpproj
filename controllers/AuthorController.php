<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\models\Author;
use yii\web\UploadedFile;
use app\models\User;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\Book;

class AuthorController extends MyCoreController
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
                'only' => ['add', 'edit', 'block', 'unblock',  'searchBlocked', 'searchUnchecked', 'allow', 'viewRestricted'],
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
                		'actions' => ['edit', 'block', 'unblock',  'searchBlocked', 'searchUnchecked', 'allow', 'viewRestricted'],
                		'allow' => true,
                		'roles' => [
                		    User::ROLE_ADMIN
                	    ],
                	],
                ],
            ],
//             'verbs' => [
//                 'class' => VerbFilter::className(),
//                 'actions' => [
//                     'logout' => ['post'],
//                 ],
//             ],
        ];
    }
    
    public function actionViewRestricted()
    {
    	$request = Yii::$app->request;
    	$id = $request->get('id');
    	$model = Author::find()
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
    	$model = Author::find()
    	               ->where(['id' => $id])
    	               ->one();
        $model->scenario = Book::SCENARIO_EDIT_RIGHTS;
    	$model->examined = 1;
    	$model->update();
    	return $this->redirect(['/author/index', 'id' => $id]);
    }
    
    public function actionBlock()
    {
    	$id = Yii::$app->request->get('id');
    	$model = Author::find()
    	               ->where(['id' => $id])
    	               ->one();
    	$model->scenario = Book::SCENARIO_EDIT_RIGHTS;
    	$model->blocked = 1;
    	$model->examined = 1;
    	$model->update();
    	return $this->redirect(['/author/view-restricted', 'id' => $id]);
    }
    
    public function actionUnblock()
    {
    	$id = Yii::$app->request->get('id');
    	$model = Author::find()
    	               ->where(['id' => $id])
    	               ->one();
    	$model->scenario = Book::SCENARIO_EDIT_RIGHTS;
    	$model->blocked = 0;
    	$model->update();
    	return $this->redirect(['/author/view-restricted', 'id' => $id]);
    }
    
    public function actionSearch()
    {
    	$searchText = Yii::$app->request->get('search');
    	if (!is_null($searchText)) {
            $models = Author::find()
                            ->distinct()
                            ->filterWhere(['like', 'name', $searchText])
//                             ->orFilterWhere(['like', 'biography', $searchText])
                            ->andFilterWhere(['blocked' => 0])
                            ->andFilterWhere(['examined' => 1])
                            ->orderBy('created_at DESC')
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
    		$models = Author::find()
    		                ->distinct()
                            ->filterWhere(['like', 'name', $searchText])
//                             ->orFilterWhere(['like', 'biography', $searchText])
                            ->andFilterWhere(['blocked' => 1])
    		                ->orderBy('created_at DESC')
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
    		$models = Author::find()
    		                ->distinct()
    		                ->filterWhere(['like', 'name', $searchText])
//     		                ->orFilterWhere(['like', 'biography', $searchText])
    		                ->andFilterWhere(['examined' => 0])
    		                ->orderBy('created_at DESC')
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
        $id = $request->post('id');
        if (is_null($id)) {
        	$id = $request->get('id');
        }        
    	$model = Author::find()
    	               ->where(['id' => $id])
    	               ->one();
    	if ($model->load(Yii::$app->request->post())) {
    		$model->examined = 0;
    		$model->photo = UploadedFile::getInstance($model, 'photo');
    		if (!$model->save() || !$model->upload()) {
    			return $this->render('edit', [
    				'model' => $model,
    			]);
    		}
    		return $this->redirect(['/author/view-restricted', 'id' => $id]);
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
     	$model = Author::find()
    	               ->where(['id' => $id, 'examined' => '1', 'blocked' => '0'])
     	               ->one();
     	if (is_null($model)) {
     		return $this->actionNoAuthor();
     	}
     	
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
    	$model = new Author();
    	if ($model->load(Yii::$app->request->post())) {
    		$model->created_at = date('Y-m-d H:i:s', time());
    		$model->photo = UploadedFile::getInstance($model, 'photo');
    		if (!$model->save() || !$model->upload()) {// make as transaction
    			var_dump($model->errors);
    			exit;
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
    
    public function actionNoAuthor()
    {
    	$this->layout = 'mainWithoutHeader';
    	return $this->render('noAuthor');
    }
    
//Ajax function for adding new book("book" controller "add" view)
    public function actionAutocomplete()
    {
    	$searchResult = null;
    	if(!empty($_POST["keyword"])) {
    		$searchResult = Author::find()
    		                      ->filterWhere(['like', 'name', $_POST["keyword"]])
    		                      ->andFilterWhere(['blocked' => 0])
    		                      ->andFilterWhere(['examined' => 1])
    		                      ->limit(10)
    		                      ->asArray()
    		                      ->all();
    	} else {
    		return;
    	}
    	$html = '<ul class="authorList">';
    	foreach($searchResult as $author) {
    		$html.= '<li onClick="selectAuthor(\''. $author["name"] .'\', '.$author["id"].');">'. $author["name"] .'</li>';
    	}
    	echo $html;
    }
//
}
