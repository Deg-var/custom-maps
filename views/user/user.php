<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use app\models\User;
use yii\bootstrap5\Html;

/**
 * @var User $user
 */

$this->title = 'Картоделы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-12 border">
            <div class="row">
                <div class="col-4">
                    <img src="<?= $user->img_url ?? '/img/user-sample.png' ?>" alt="Аватарка <?= $user->username ?>"
                         style="max-width: 100%">
                </div>
                <div class="col-8">
                    <p><?= $user->username ?></p>
                    <p><?= $user->description ?></p>
                </div>
            </div>
            <div></div>
            <?php if ($user->maps): ?>
                <div class="row mt-3">
                    <?= $this->renderAjax('../common-components/_maps-list', ['maps' => $user->maps]) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
