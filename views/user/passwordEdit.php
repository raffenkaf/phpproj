<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование данных пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1> <?= $this->title ?> </h1>
<div class="registrationData">
    <?php $form = ActiveForm::begin([
        'id' => 'add-user',
        'options' => ['class' => 'registrationData']    		
    ]); ?>
        <?= $form->field($model, 'old_password')->passwordInput() ?>
        <?= $form->field($model, 'new_password')->passwordInput() ?>
        <?= $form->field($model, 'new_password_repeat')->passwordInput() ?>
        <?= Html::submitButton('Сохранить', ['id' => 'saveButton']) ?>
    <?php $form = ActiveForm::end(); ?>
</div>