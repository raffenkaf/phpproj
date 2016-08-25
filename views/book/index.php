<?php

use yii\helpers\Html;
use app\models\User;

$this->title = Html::encode($model->title);
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($model->blocked) { ?>
<h2> Книга заблокирована </h2>
<?php } ?>
<?php if (!$model->examined) { ?>
<h2> Книга непроверена </h2>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#downloadLink").click(function(){
		$.ajax({
		    type: "POST",
		    url: "/book/download-register",
		    data:"id="+<?= $model->id ?>,
		});
	});
});
</script>
<h1> <?= Html::encode($model->title) ?> </h1>
    <div class="photo">
        <h2> Обложка </h2>
        <img alt="personalPhoto" src="<?= Yii::getAlias('@web').'/'.$model->book_cover_path ?>">
    </div>
    <div class="authorData">
        <table class="personalDataTable">
            <tr>
            <td> Автор(ы): </td>
            <td>
                <?php foreach ($model->authors as $author) { ?>
                    <?= Html::a($author->name, ['/author/index', 'id' =>$author->id]) ?>
                    <br />                
                <?php } ?>  
            </td>
            </tr>
            <tr>
            <td> Дата издания: </td>
            <td> <?= $model->published_date ?> </td>
            </tr>
            <tr>
            <td> Жанр/жанры: </td>
            <td> <?= Html::encode($model->genre) ?> </td>
            </tr>
            <tr>
            <td> Аннотация: </td>
            </tr>
            <tr>
            <td colspan="2"> <?= Html::encode($model->description) ?> </td>
            </tr>
            <tr>
                <td>
                    <?= Html::a('Скачать', [Yii::getAlias('@web').'/'.$model->file_path], 
                    		    ['class' => 'buttonLink', 'id'=>'downloadLink', 'download']) 
                    ?> <br />
                    <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->getIdentity()->role == User::ROLE_ADMIN)) { ?>
                        <?= Html::a('Редактировать', ['book/edit', 'id' => $model->id], ['class' => 'buttonLink']) ?> <br />
                        <?php if ($model->examined == 0) { ?> 
                            <?=  Html::a('Одобрить', ['book/allow', 'id' => $model->id], ['class' => 'buttonLink']) ?> <br /> 
                        <?php } ?>
                        <?php if ($model->blocked == 1) { ?>
                         	<?= Html::a('Разблокировать', ['book/unblock', 'id' => $model->id], ['class' => 'buttonLink']) ?> <br />
                        <?php } else { ?>
                            <?= Html::a('Заблокировать', ['book/block', 'id' => $model->id], ['class' => 'buttonLink']) ?> <br /> 
                        <?php } ?>
                    <?php } ?>                     
                </td>
            </tr>
            
        </table>        
    </div>