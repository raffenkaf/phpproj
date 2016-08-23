<?php
use yii\helpers\Html;

$this->title = 'Функции администратора';
$this->params['breadcrumbs'][] = $this->title;
?>

<H4>В функции администратора входит рассмотрение и допуск новых авторов/книг.</H4>
<H4>Права администратора так же позволяют редактировать и блокировать уже допущенных а/к,</H4>
<H4>просмотр и поиск среди заблокированных/недопущенных а/к. </H4>
<H5>Для просмотра всех доступных а/к ничего не вводите в соответствующее поле поиска и нажмите кнопку "Поиск" </H5>

<div class="search">
     <?= Html::beginForm(
     		['book/search-blocked'],
     		'get',
            ['id' => 'searchBlockedBook']
     ); ?>
        <?= Html::label("Поиск книги среди заблокированных:") ?>
        <?= Html::textInput('search', null ,['class' => 'searchInput']); ?>
        <?= Html::submitButton('Поиск', ['class' => 'loginButton']) ?>      
     <?= Html::endForm(); ?>
     
     <?= Html::beginForm(
     		['book/search-unchecked'],
     		'get',
            ['id' => 'searchUncheckedBook']
     ); ?>
        <?= Html::label("Поиск книги среди непроверенных:") ?>
        <?= Html::textInput('search', null ,['class' => 'searchInput']); ?>
        <?= Html::submitButton('Поиск', ['class' => 'loginButton']) ?>    
          
     <?= Html::endForm(); ?>
          <?= Html::beginForm(
     		['author/search-blocked'],
     		'get',
            ['id' => 'searchBlockedAuthor']
     ); ?>
        <?= Html::label("Поиск автора среди заблокированных:") ?>
        <?= Html::textInput('search', null ,['class' => 'searchInput']); ?>
        <?= Html::submitButton('Поиск', ['class' => 'loginButton']) ?>      
     <?= Html::endForm(); ?>
     
     <?= Html::beginForm(
     		['author/search-unchecked'],
     		'get',
            ['id' => 'searchUncheckedAuthor']
     ); ?>
        <?= Html::label("Поиск автора среди непроверенных:") ?>
        <?= Html::textInput('search', null ,['class' => 'searchInput']); ?>
        <?= Html::submitButton('Поиск', ['class' => 'loginButton']) ?>      
     <?= Html::endForm(); ?>
</div>