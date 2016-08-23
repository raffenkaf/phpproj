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
    <form action="login.php" method="post">
        <?= Html::a('Вход', ['user/login'], ['class' => 'personalPage']) ?>
        <?= Html::a('Регистрация', ['user/add'], ['class' => 'personalPage']) ?>
    </form>
</div>
 
