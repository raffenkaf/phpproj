<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\User;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\LoginForm;

class UserController extends MyCoreController
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
                'only' => ['add', 'edit', 'index'],
                'rules' => [
                	[
                		'actions' => ['add'],
                		'allow' => true,
                		'roles' => ['?']
                	],
                    [
                        'actions' => ['index','edit'],
                        'allow' => true,
                        'roles' => [
                             User::ROLE_USER,
                             User::ROLE_ADMIN
                        ]
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                	'add' => ['post', 'get'],
                ],
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
    	return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionAdd()
    {
    	$this->layout = 'mainWithoutHeader';
    	$model = new User(['scenario' => User::SCENARIO_DEFAULT]);
    	if ($model->load(Yii::$app->request->post())) {
    		$model->photo = UploadedFile::getInstance($model, 'photo');

    		if (!$model->save() || !$model->upload()) {
    			return $this->render('add', [
    				'model' => $model,
    			]);
    		}

    		return $this->redirect('/user/login');
    	}
    	
    	return $this->render('add', [
            'model' => $model,
        ]);
    }
    
    public function actionEdit()
    {
    	$this->layout = 'mainWithoutHeader';
    	$model = User::findOne(Yii::$app->user->id);
    	$model->scenario = User::SCENARIO_EDIT;
    	if ($model->load(Yii::$app->request->post())) {
    		$model->photo = UploadedFile::getInstance($model, 'photo');
    		if (!$model->save() || !$model->upload()) {
    			return $this->render('edit', [
    					'model' => $model,
    			]);
    		}
    		return $this->redirect('/user/index');
    	}
    	 
    	return $this->render('edit', [
    			'model' => $model,
    	]);
    }
    
    public function actionPasswordEdit()
    {
    	$this->layout = 'mainWithoutHeader';
    	$model = User::findOne(Yii::$app->user->id);
    	$model->scenario = User::SCENARIO_EDIT_PASS;
    	if ($model->load(Yii::$app->request->post())) {
    		if (!$model->validatePassword($model->old_password)) {
    			$model->addError('old_password', 'Пароль указан неверно');
    			return $this->render('passwordEdit', [
    			        'model' => $model,
    	        ]);
    		}
    		
    		$model->password = \Yii::$app->security->generatePasswordHash($model->new_password);
    		
    		if (!$model->save()) {
    			return $this->render('passwordEdit', [
    					'model' => $model,
    			]);
    		}
    		return $this->redirect('/user/index');
    	}
    
    	return $this->render('passwordEdit', [
    			'model' => $model,
    	]);
    }
    
    public function actionLogin()
    {
    	$this->layout = 'mainWithoutHeader';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionLogout()
    {
    	Yii::$app->user->logout();
    
    	return $this->goHome();
    }
    
    public function actionThanks() {
    	$this->layout = 'mainWithoutHeader';
    	return $this->render('thanks');
    }
    
    public function actionAdmin()
    {
    	$this->layout = 'mainWithoutHeader';
    	return $this->render('admin');
    }
}
