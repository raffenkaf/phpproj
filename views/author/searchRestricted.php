<?php
use yii\helpers\Html;

$this->title = 'Поиск автора';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php foreach ($models as $model) { ?>
<div class="searchResult">
    <div class="searchPhoto">
        <?= Html::a('<img alt="personalPhoto" src="'.Yii::getAlias('@web').'/'.$model->photo_path.'" >', 
        		    ['author/view-restricted', 'id' => $model->id]) 
        ?>
    </div>
    <div class="searchTextData">
        <h4><?= Html::a($model->name, ['author/view-restricted', 'id' => $model->id]) ?> </h4>
    </div>
</div>
<?php } ?>