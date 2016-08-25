<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);
//What header to choose?(Мб на русском писать? Нет - если иностранцы, потом переписывать.)
$headerType =  '@app/views/layouts/headerUnregistered.php';//default header is header for unregistered users

if (!Yii::$app->user->isGuest && 
            (Yii::$app->user->getIdentity()->role == User::ROLE_ADMIN)) {//this one for admin
	$headerType =  '@app/views/layouts/headerAdmin.php';
}elseif (!Yii::$app->user->isGuest && 
            (Yii::$app->user->getIdentity()->role == User::ROLE_USER)){//this one for user
    $headerType =  '@app/views/layouts/headerUser.php';
}
//
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
<div class="header">
    <?php $this->beginContent($headerType); ?>
    <?php $this->endContent(); ?>
</div>
<div class="search">
     <?= Html::beginForm(
     		['book/search'],
     		'get',
            ['id' => 'search-book']
     ); ?>
        <?= Html::label("Поиск книги:") ?>
        <?= Html::textInput('search', null ,['class' => 'searchInput']); ?>
        <?= Html::submitButton('Поиск', ['class' => 'loginButton']) ?>      
     <?= Html::endForm(); ?>
     
     <?= Html::beginForm(
     		['author/search'],
     		'get',
            ['id' => 'search-author']
     ); ?>
        <?= Html::label("Поиск автора:") ?>
        <?= Html::textInput('search', null ,['class' => 'searchInput']); ?>
        <?= Html::submitButton('Поиск', ['class' => 'loginButton']) ?>      
     <?= Html::endForm(); ?>
</div>
<div class="warning">
    <h4>Данный сайт создан исключительно в ознакомительных целях. 
        То есть служит приложением к <a href="resume.pdf" download>резюме</a>.        
    </h4>
    <p> Пользователь с правами админа Login-admin, Password - adminadmin. </p>
    <p> Тематика сайта - онлайн библиотека. </p>
</div>
<div class="mainContent">
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
