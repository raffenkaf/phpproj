<?php
use yii\helpers\Html;

$this->title = 'Поиск книги';
$this->params['breadcrumbs'][] = ['label' => 'Функции администратора', 'url' => ['user/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach ($models as $model) { ?>
<div class="searchResult">
    <div class="searchPhoto">
        <?= Html::a('<img alt="personal photo" src="'.Yii::getAlias('@web').'/'.$model->book_cover_path.'" >', 
        		    ['book/view-restricted', 'id' => $model->id]) ?>
    </div>
    <div class="searchTextData">
        <h4><?= Html::a($model->title, ['book/view-restricted', 'id' => $model->id] ) ?> </h4>
        <h5>
            <?php foreach ($model->authors as $author) { ?>                
        	    <?= Html::a($author->name, ['author/view-restricted', 'id' => $author->id]) ?>
            <?php } ?>         
         </h5>
    </div>
</div>
<?php } ?>