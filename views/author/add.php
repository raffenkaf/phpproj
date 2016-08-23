<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Добавление автора';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1> <?= $this->title ?> </h1>
<div class="registrationData">
    <?php $form = ActiveForm::begin([
        'id' => 'add-author',
        'options' => ['class' => 'registrationData']    		
    ]); ?>
        <?= $form->field($model, 'name')->textInput()->label('Имя(или псевдоним)') ?>
        <?= $form->field($model, 'birth_date')->widget(DatePicker::className(), [
        	    'dateFormat' => 'yyyy-MM-dd'                
            ]);
        ?>
        <?= $form->field($model, 'biography')->textarea([
        	    'rows' => '10',
        	    'cols' => '41'
            ])->hint('Кратко про автора')
        ?>
        <?= $form->field($model, 'photo')->fileInput() ?>
        <?= Html::submitButton('Сохранить', ['id' => 'saveButton']) ?>
    <?php $form = ActiveForm::end(); ?>
</div>
