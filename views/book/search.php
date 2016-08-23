<?php
use yii\helpers\Html;

$this->title = 'Поиск книги';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php foreach ($models as $model) { ?>
<div class="searchResult">
    <div class="searchPhoto">
        <?= Html::a('<img alt="personal photo" src="'.Yii::getAlias('@web').'/'.$model->book_cover_path.'" >', 
        		    ['book/index', 'id' => $model->id]) ?>
    </div>
    <div class="searchTextData">
        <h4><?= Html::a($model->title, ['book/index', 'id' => $model->id] ) ?> </h4>
        <h5>
            <?php foreach ($model->authors as $author) { ?>                
        	    <?= Html::a($author->name, ['author/index', 'id' => $author->id]) ?>
            <?php } ?>         
         </h5>
    </div>
</div>
<?php } ?>