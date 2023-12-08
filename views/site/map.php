<?php

use app\assets\CommentAsset;
use app\assets\MapAsset;
use app\models\Game;
use app\models\Map;
use app\models\User;
use yii\bootstrap5\Html;

/**
 * @var yii\web\View $this
 * @var yii\bootstrap5\ActiveForm $form
 * @var app\models\LoginForm $model
 * @var User $user
 * @var Map $map
 */

CommentAsset::register($this);
MapAsset::register($this);

$this->title = $map->name ?? null;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site">
    <?php if ($map): ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-12 border">
                <div class="row">
                    <div class="col-12">
                        <div class="row pt-3">
                            <div class="col-lg-2 col-4 text-center">
                                <div>
                                    <img src="<?= !empty($map->img_link) ? $map->img_link : $map->game->default_img_url ?>"
                                         alt="" style="height: 20vh; width: 100%">
                                </div>
                                <div class="text-start forMapLike mapId-<?= $map->id ?>" id="mapId-<?= $map->id ?>"
                                     data-map-id="<?= $map->id ?>" style="position: relative; top: 30%">
                                    <?= $this->renderAjax('_map-likes', ['map' => $map]) ?>
                                </div>
                            </div>

                            <div class="col-lg-4 col-2">
                                <div class="row">
                                    <div class="col-12"><?= $map->name ?></div>
                                    <div class="col-12"><?= $map->description ?></div>
                                    <div class="col-12 mt-2">Автор: <?= $map->user->username ?></div>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <?php if ($map->video_link): ?>
                                    <iframe width="560" height="320"
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
                            <?php if ($map->user_id === Yii::$app->user->id): ?>
                                <div class="col-12 text-end">
                                    <?= Html::a('Редактировать', ['site/map-edit', 'id' => $map->id], ['class' => 'btn btn-warning']) ?>
                                </div>
                                <div class="col-5 text-end">
                                    <?= Html::button('Не удаляй меня, семпай!!',
                                        ['class' => 'btn btn-danger delete-map', 'data-map-id' => $map->id]
                                    ) ?>
                                </div>
                            <?php else: ?>
                                <div class="col-12 text-end">
                                    <?= Html::a('ХОЧУ!', $map->mod_link, ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <h2>Комментарии</h2>
                            <div class="col-12 border border-1 p-3 comment-list" style="border-radius: 5px">
                                <div id="forOldComments">
                                    <?= $this->renderAjax('_map-comments', ['map' => $map]) ?>
                                </div>
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <div class="row border border-dark border-2">
                                        <div class="col-10 offset-2">
                                            <h5>Новый коммент</h5>
                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                        <textarea id="newCommentText" cols="10"
                                                  style="width: 100%" data-map-id="<?= $map->id ?>"></textarea>
                                        </div>
                                        <div class="col-12 text-end">
                                            <?= Html::button('Отправить', ['class' => 'btn btn-warning', 'id' => 'newCommentBtn',]) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div>Ты че то попутал</div>
    <?php endif; ?>
</div>
