<?php

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;

$this->title = 'Такой автор не найден.';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1> Такой автор не найден </h1>
    <?= Html::a("Домашняя страница", "/", ['class' => 'buttonLink']) ?>