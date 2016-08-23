<?php

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;

$this->title = 'Нет такой книги';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1> Такой книги у нас нет </h1>
    <?= Html::a("Домашняя страница", "/", ['class' => 'buttonLink']) ?>
