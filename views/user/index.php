<?php

use yii\helpers\Html;

$this->title = 'Личная страница пользователя';
?>
<h1>Личные данные</h1>
<div class="photo">
<h2> Аватар </h2>
<img alt="personal photo" src="<?= '/'.Yii::$app->user->identity->avatar_path ?>">
</div>
<div class="personalData">
<table class="personalDataTable">
<tr>
<td> Имя: </td>
<td> <?= Html::encode(Yii::$app->user->identity->name) ?> </td>
</tr>
<tr>
<td> Фамилия: </td>
<td> <?= Html::encode(Yii::$app->user->identity->last_name) ?> </td>
</tr>
<tr>
<td> Отчество: </td>
<td> <?= Html::encode(Yii::$app->user->identity->patronymic) ?> </td>
</tr>
<tr>
<td> Ник(псевдоним): </td>
<td> <?= Html::encode(Yii::$app->user->identity->nickname) ?> </td>
</tr>
<tr>
<td> Логин: </td>
<td> <?= Html::encode(Yii::$app->user->identity->login) ?> </td>
</tr>
<tr>
<td> Дата рождения: </td>
<td> <?= Html::encode(Yii::$app->user->identity->birth_date) ?> </td>
</tr>
<tr>
<td> Доброе дело №1: </td>
<td> <?= Html::a('Добавить автора', ['author/add'], ['class' => 'buttonLink']) ?> </td>
</tr>
<tr>
<td> Доброе дело №2: </td>
<td> <?= Html::a('Добавить книгу', ['book/add'], ['class' => 'buttonLink']) ?> </td>
</tr>
<tr>
<td colspan="2"> <?= Html::a('Изменить личные данные', ['user/edit'], ['class' => 'buttonLink']) ?> </td>
</tr>
<tr>
<td colspan="2"> <?= Html::a('Изменить пароль', ['user/password-edit'], ['class' => 'buttonLink']) ?> </td>
</tr>
</table>
</div>
