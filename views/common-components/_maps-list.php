<?php

/**
 * @var Map[] $maps ,
 */

use app\models\Map;

foreach ($maps as $key => $map): ?>
    <div class="mt-0  <?= Yii::$app->controller->id === 'user' ? 'col-lg-4 col-xl-4 p-3' : 'col-12 p-2' ?>">
        <div class="row"
             style="background-color:<?= fmod($key, 2) ? 'deepskyblue' : 'lightblue'; ?>; border-radius: 10px">
            <div class="col-12  text-center">
                <a class="col-12"
                   href="/map/<?= $map->id ?>" style="width: 50%;">
                    <img src="<?= !empty($map->img_link) ? $map->img_link : $map->game->default_img_url ?>"
                         class="map-img pt-3" alt="">
                </a>
                <div class="row">
                    <div class="col-auto">Игра:</div>
                    <div class="col-auto text-start"><?= $map->game?->name ?></div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <a class="col-12"
                       href="/map/<?= $map->id ?>"><?= $map->name ?></a>
                    <div class="col-12"><?= $map->description ?></div>
                </div>
            </div>
            <div class="text-end forMapLike col-12 mapId-<?= $map->id ?>" id="mapId-<?= $map->id ?>"
                 data-map-id="<?= $map->id ?>" style="position: relative; top: 45%">
                <?= $this->render('../common-components/_map-likes', ['map' => $map]) ?>
            </div>
        </div>
    </div>
<?php endforeach;