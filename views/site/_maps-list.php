<?php

/**
 * @var Map[] $maps ,
 */

use app\models\Map;

foreach ($maps as $key => $map): ?>
    <div class="col-12 mt-3 p-3"
         style="background-color:<?= fmod($key, 2) ? 'deepskyblue' : 'lightblue'; ?>; border-radius: 10px">
        <div class="row">
            <div class="col-12  text-center">
                <a class="col-12"
                   href="/site/map?id=<?= $map->id ?>">
                    <img src="<?= !empty($map->img_link) ? $map->img_link : $map->game->default_img_url ?>" alt=""
                         style="height: 20vh">
                </a>
                <div class="row">
                    <div class="col-auto">Игра:</div>
                    <div class="col-auto text-start"><?= $map->game?->name ?></div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <a class="col-12"
                       href="/site/map?id=<?= $map->id ?>"><?= $map->name ?></a>
                    <div class="col-12"><?= $map->description ?></div>
                </div>
            </div>
            <div class="text-end forMapLike col-12 mapId-<?= $map->id ?>" id="mapId-<?= $map->id ?>"
                 data-map-id="<?= $map->id ?>" style="position: relative; top: 45%">
                <?= $this->render('_map-likes', ['map' => $map]) ?>
            </div>
        </div>
    </div>
<?php endforeach;