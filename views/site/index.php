<?php
use yii\helpers\Html;
$this->title = 'Че бы почитать?';
?>
<h2>Выбор пользователей</h2>
    <div class="leftUserWatchChoice">
        <h3> Топ просматриваемых </h3>
        <?= Html::a('<img alt="book logo" src="'.$maxViewModel->book_cover_path.'" >', ['book/index', 'id' => $maxViewModel->id]) ?> <br />
        <?php foreach ($maxViewModel->authors as $author) { ?>
            <?= Html::a($author->name, ['author/index', 'id' => $author->id]) ?> 
        <?php } ?> <br />
        <b><?= Html::a($maxViewModel->title, ['book/index', 'id' => $maxViewModel->id]) ?></b> 
    </div>        
    <div class="rightUserDownloadChoice">
        <h3> Топ скачиваемых </h3>
        <?= Html::a('<img alt="book logo" src="'.$maxDownloadModel->book_cover_path.'" >', ['book/index', 'id' => $maxDownloadModel->id]) ?> <br />
        <?php foreach ($maxDownloadModel->authors as $author) { ?>
                        <?= Html::a($author->name, ['author/index', 'id' => $author->id]) ?>
        <?php } ?> <br />
        <b><?= Html::a($maxDownloadModel->title, ['book/index', 'id' => $maxDownloadModel->id]) ?></b> 
    </div>
    <div class="interestingLinks">
    <h4><?= Html::a('Перейти к списку всех книг', ['book/search', 'search'=>'']) ?></h4>        
    <h4><?= Html::a('Иные способы отдыха', 'http://www.skok.kiev.ua/') ?> </h4>
    </div>