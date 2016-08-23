<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ошибка возникла в процессе обработки вашего запроса.
    </p>
    <p>
        Пожалуйста свяжитесь с нами, если вы думаете что это ошибка со стороны сервера.
    </p>

</div>
