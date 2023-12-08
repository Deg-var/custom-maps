<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use app\models\User;
use yii\bootstrap5\Html;

/**
 * @var User[] $users
 */

$this->title = 'Картоделы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">
            <div class="row">
                <?php foreach ($users as $user): ?>
                    <div class="col-12 border p-2">
                        <div class="row">
                            <div class="col-4">
                                <img src="<?= $user->img_url ?? '/img/user-sample.png' ?>" alt="Аватарка <?= $user->username ?>" style="height: 20vh; width: 100%">
                            </div>
                            <div class="col-8">
                                <h4><?= $user->username ?></h4>
                                <p><?= $user->description ?></p>
                                <?= Html::a('Посмотреть все карты', ['site/user', 'id' => $user->id], ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
