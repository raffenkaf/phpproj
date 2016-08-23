<?php

use yii\helpers\Html;
use app\models\User;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>Страница автора</h1>
    <div class="photo">
        <h2> Фото </h2>
        <img alt="personalPhoto" src="<?= Yii::getAlias('@web').'/'.$model->photo_path ?>" >      
    </div>        
    <div class="authorData">
        <table class="personalDataTable">
            <tr>
            <td> Имя(псевдоним): </td>
            <td> <?= Html::encode($model->name) ?> </td>
            </tr>
            <tr>
            <td> Дата рождения: </td>
            <td> <?= $model->birth_date ?> </td>
            </tr>
            <tr>
            <td colspan="2"> Краткая биография: </td>
            </tr>
            <tr>
            <td colspan="2"> <?= Html::encode($model->biography) ?> </td>
            </tr>
            <tr>
            <td colspan="2"> Книги: </td>
            </tr>
            <tr>            
                <td colspan="2"> 
                    <?php foreach ($model->books as $book) { ?>
                         <?= Html::a($book->title, ['/book/index', 'id' => $book->id]) ?> <br />                
                    <?php } ?><br />
                </td>
            </tr>
            <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->getIdentity()->role == User::ROLE_ADMIN)) { ?>
            <tr>
                <td> 
                    <?= Html::a('Редактировать', ['author/edit', 'id' => $model->id], ['class' => 'buttonLink']) ?><br />
                    <?php if ($model->examined == 0) { ?>
                        <?= Html::a('Одобрить', ['author/allow', 'id' => $model->id], ['class' => 'buttonLink']) ?><br /> 
                    <?php } ?>
                    <?php if ($model->blocked == 1) { ?>
                        <?= Html::a('Разблокировать', ['author/unblock', 'id' => $model->id], ['class' => 'buttonLink']) ?><br />
                    <?php } else { ?>
                    <?= Html::a('Заблокировать', ['author/block', 'id' => $model->id], ['class' => 'buttonLink']) ?><br />
                    <?php } ?> 
                </td>
            </tr>
            <?php } ?>
        </table>        
    </div>