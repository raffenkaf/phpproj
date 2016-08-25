<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Регистрация нового пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1> <?= $this->title ?> </h1>
<div class="registrationData">
    <?php $form = ActiveForm::begin([
        'id' => 'add-user',
        'options' => ['class' => 'registrationData']    		
    ]); ?>
	
        <?= $form->field($model, 'login')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'last_name')->textInput() ?>
        <?= $form->field($model, 'patronymic')->textInput() ?>
        <?= $form->field($model, 'FIO_visibility')->checkbox([], false) ?>
        <?= $form->field($model, 'nickname')->textInput() ?>
        <?= $form->field($model, 'birth_date')->widget(DatePicker::className(), [
        	    'dateFormat' => 'yyyy-MM-dd'                
            ]);
        ?>
        <?= $form->field($model, 'photo')->fileInput() ?>
        <?= Html::submitButton('Сохранить', ['id' => 'saveButton']) ?>
    <?php $form = ActiveForm::end(); ?>
</div>
