<?php

use app\assets\MapAsset;
use app\models\Map;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var Map[] $newMaps ,
 * @var Map[] $someAoe2deMaps ,
 * @var Map[] $someWarcraft3Maps ,
 */

$this->title = 'Кастомки главное в жизни';

MapAsset::register($this);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Дратвуйте!</h1>

        <p class="lead">Вы нашлись! Мы вас долго искали! Теперь мы можем дать вам поиграть интересные карты.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-12 text-center mb-3">
                <h4>Если вам понравится можете <a href="https://boosty.to/pankyxaa" target="_blank">поддержать</a></h4>
            </div>
            <div class="col-12 text-center mb-3">
                <h5>А еще у нас появился бот, который может выдавать случайные карты добавлены на сайт <a
                            href="https://t.me/custom_maps_bot" target="_blank">ТЫК</a></h5>
            </div>
            <div class="col-12 text-center mb-3">
                <h6>Если если хотите следить доработками для этого сайта то можете почитать <a
                            href="https://boosty.to/pankyxaa" target="_blank">бусти</a>, это бесплатно</h6>
            </div>

            <div class="col-lg-4 mb-3">
                <h2>Новые карты</h2>

                <div class="row m-1">
                    <?= $this->renderAjax('../common-components/_maps-list', ['maps' => $newMaps]) ?>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Случайные карты для Эпохи</h2>
                <div class="row m-1">
                    <?= $this->renderAjax('../common-components/_maps-list', ['maps' => $someAoe2deMaps]) ?>
                </div>
            </div>
            <div class="col-lg-4">
                <h2>Случайные карты для Варика</h2>
                <div class="row m-1">
                    <?= $this->renderAjax('../common-components/_maps-list', ['maps' => $someWarcraft3Maps]) ?>
                </div>
            </div>
        </div>

    </div>
</div>
