<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Редактирование данных автора';
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
            ])
        ?>
        <div class="cover">
            <img alt="Фото" src="<?= Yii::getAlias('@web').'/'. $model->photo_path ?>">
        </div>  
        <?= $form->field($model, 'photo')->fileInput() ?>
        <?= Html::submitButton('Сохранить', ['id' => 'saveButton']) ?>
    <?php $form = ActiveForm::end(); ?>
</div>
