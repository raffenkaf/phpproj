<?php

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;

$this->title = 'Спасибо';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1> Спасибо за регистрацию. </h1>
    <?= Html::a("Домашняя страница", "/", ['class' => 'buttonLink']) ?>
