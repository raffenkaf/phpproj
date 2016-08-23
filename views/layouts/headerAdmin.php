<?php
use yii\helpers\Html;
?>

<div class="proverb">
        <p> <i> Все что вам необходимо – уже внутри вас. Я верю, <br />
            что люди сами создают свой рай и свой ад. Это личный выбор. </i>
        </p>           
        <br />
        <p> Karl Logan </p>
        <p> Manowar </p>
</div>
<div class="authorization">
    <h4> Вы авторизировались </h4>
    <h5> под ником <b> "<?= Yii::$app->user->getIdentity()->nickname ?>" </b></h5>
    <h5> <i> 
         <?= Yii::$app->user->getIdentity()->last_name.' '.
                 Yii::$app->user->getIdentity()->name.' '.
                 Yii::$app->user->getIdentity()->patronymic;
         ?>
    </i> </h5>
    <?= Html::a('Выход', ['user/logout'], ['class' => 'personalPage']) ?>
    <?= Html::a('Личный кабинет', ['user/index'], ['class' => 'personalPage']) ?>
    <?= Html::a('Функции администратора', ['user/admin'], ['class' => 'personalPage']) ?>
</div> 
