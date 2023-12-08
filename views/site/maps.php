<?php

use app\assets\MapAsset;
use app\models\Map;
use app\models\User;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\data\Pagination;


/**
 * @var yii\web\View $this
 * @var yii\bootstrap5\ActiveForm $form
 * @var app\models\LoginForm $model
 * @var User $user
 * @var Map[] $maps
 * @var Pagination $pages
 */

MapAsset::register($this);

if ($this->context->action->id === 'aoe2de') {
    $this->title = 'Карты для эпохи';
} elseif ($this->context->action->id === 'warcraft3') {
    $this->title = 'Карты для варика';
} else {
    $this->title = 'Твои карты';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('Добавить карту', ['site/new-map'], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row mt-3">
        <div class="col-12 border">
            <div class="row">
                <?php foreach ($maps as $map): ?>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-lg-2 col-4  text-center">
                                <img src="<?= !empty($map->img_link) ? $map->img_link : $map->game->default_img_url ?>"
                                     alt="" style="height: 20vh; width: 100%">
                                <div class="row">
                                    <div class="col-auto">Игра:</div>
                                    <div class="col-auto text-start"><?= $map->game?->name ?></div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-2">
                                <div class="row">
                                    <a class="col-12" href="/site/map?id=<?= $map->id ?>"><?= $map->name ?></a>
                                    <div class="col-12"><?= $map->description ?></div>
                                    <div class="col-12 mt-2">Автор: <?= $map->user->username ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <?php if ($map->video_link): ?>
                                    <iframe height="320" style="width: 100%"
                                            src="https://www.youtube.com/embed/<?= $map->video_link ?>?si=I70j_Vm7ipd6Ay5s"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                <?php else: ?>
                                    <img
                                            src="https://i.imgur.com/yHcoZLM.jpg"
                                            alt=""
                                            style="max-width: 560px;max-height: 320px"
                                    >
                                <?php endif; ?>
                            </div>
                            <div class="text-start forMapLike col-2 mapId-<?= $map->id ?>" id="mapId-<?= $map->id ?>"
                                 data-map-id="<?= $map->id ?>" style="position: relative; top: 45%">
                                <?= $this->renderAjax('_map-likes', ['map' => $map]) ?>
                            </div>
                            <?php if (Yii::$app->user->id === $map->user_id): ?>
                                <div class="col-10 text-end">
                                    <?= Html::a('Редактировать', ['site/map-edit', 'id' => $map->id], ['class' => 'btn btn-warning']) ?>
                                </div>
                                <div class="col-5 text-end">
                                    <?= Html::button('Не удаляй меня, семпай!!', ['class' => 'btn btn-danger delete-map', 'target' => '_blank']) ?>
                                </div>
                            <?php else: ?>
                                <div class="col-5 text-end">
                                    <?= Html::a('ХОЧУ!', $map->mod_link, ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="nav-bar">
                    <?= LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
