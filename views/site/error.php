<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */

/** @var Exception $exception */

use yii\helpers\Html;

$this->title = 'Ошибочка';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>
        Что-то пошло не так,
        <?= Html::a('тык', [
            '/map-telegram-bot/send-massage',
            'url' => $this->context->request->url,
            'code' => $this->title,
            'message' => nl2br(Html::encode($message)),
            'userId' => Yii::$app->user->id
        ]) ?>
        и Pankyxaa разберется.
    </p>
</div>
