<?php

use app\assets\MapAsset;
use app\assets\UsefulAsset;
use app\models\Map;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var Map[] $newMaps ,
 * @var Map[] $someAoe2deMaps ,
 * @var Map[] $someWarcraft3Maps ,
 */

$this->title = 'My Yii Application';

UsefulAsset::register($this);

?>
<div class="site-index h-100">

    <div class="jumbotron text-center bg-transparent mb-5">
        <h1 class="display-4 text-light mt-5 mt-xl-0">Картоделишь!?</h1>
    </div>
    <div class="h-100"
         style="
         background-image: url('/img/morpheus.jpg');
         background-repeat: no-repeat;
         background-position-x: center;
         background-position-y: top;
"
    >
        <div class="text-light d-flex justify-content-around" style="padding-top: 350px">
            <?= Html::a(
                '<img src="/img/left-hand.jpg" alt="">',
                '/useful/aoe',
                [
                    'class' => 'real-show-hint',
                    'data-hint' => '#real-hint-1',
                    'style' => 'height: 150px',
                    'title' => 'Да, в эпохе',
                ]
            ) ?>
            <?= Html::a(
                '<img src="/img/right-hand.jpg" alt="">',
                '/useful/warcraft3',
                [
                    'class' => 'real-show-hint',
                    'data-hint' => '#real-hint-2',
                    'style' => 'height: 150px',
                    'title' => 'Я по варику',
                ]
            ) ?>
        </div>
    </div>
</div>
<div id="real-hint-1" class="real-hint text-center">
    <span class="hint-caption">Да, в Эпохе</span><br/>
</div>

<div id="real-hint-2" class="real-hint text-center">
    <span class="hint-caption">Я по варику</span><br/>
</div>
