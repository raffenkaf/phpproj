<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="general">
<div class="warningWithoutHeader">
    <h4>Данный сайт создан исключительно в ознакомительных целях. 
        То есть служит приложением к <a href="resume.html">резюме</a>.
    </h4>
    <p> Тематика сайта - онлайн библиотека. </p>
</div>
<div class="mainContentWithoutHeader">
	<?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= $content ?>
</div>
<div class="footer">
    <p>Если Вам захотелось сказать мне «молодец» (или Вы хотите пригласить меня на собеседование) - 
       пишите на raffenkaf@gmail.com/звоните по н.т. 0661607949.</p>
</div>

</div><?php //end of general ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
