<?php

use app\assets\AoeUsefulAsset;
use app\assets\AoeUsefulVeiwedAsset;
use app\models\Map;

/**
 * @var $aoeIntroTextForMapCreatorViewed ,
 */

$this->title = 'My Yii Application';
if (!$aoeIntroTextForMapCreatorViewed) {
    AoeUsefulAsset::register($this);
}

AoeUsefulVeiwedAsset::register($this);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5"
         style="color: yellow; font-family:'Droid Sans', arial, verdana, sans-serif;">
        <h1 class="display-4">Здравствуй товарищ!</h1>
        <p class="lead">Как бы пафосно это не звучало, но у меня есть немного мудрости, и я бы хотел ей поделится</p>
    </div>

    <div class="body-content mb-5"
         style="color: yellow; font-family:'Droid Sans', arial, verdana, sans-serif;"
         data-aoe-intro-text-for-map-creator-viewed="<?= $aoeIntroTextForMapCreatorViewed ? 'yes' : 'no' ?>"
    >
        <div id="titles" style="display: <?= $aoeIntroTextForMapCreatorViewed ? 'none' : 'block' ?>">
            <div id="titlecontent">
                <div>Давным давно, в далеком 1999 году вышла Age of Empires 2.</div>
                <br>
                <div>Потом для нее вышел UserPatch, который был включен в HD перееиздание.</div>
                <br>
                <div>После был создан еше один UserPatch, и который снова был включен в DE перееиздание.</div>
                <br>
                <div>И по сей день UserPatch разрабатывается и вносится в Эпоху уже разрабами из майкрософта.</div>
                <br>
                <div>И в этом во всем надо хотя бы чуть-чуть разбираться если хочешь делать карты для эпохи.</div>
                <br>
            </div>
        </div>
        <div style="display: <?= $aoeIntroTextForMapCreatorViewed ? 'block' : 'none' ?>">
            <div class="row">
                <div class="col-12">
                    <div class="row mt-3">
                        <div class="col-4">
                            <iframe src="https://www.youtube.com/embed/4wW2vET5lBQ?si=sfn1u5YpPEoujgwB"
                                    style="width: 100%"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                        </div>
                        <div class="col-8">Не большой вступительный ролик чисто для ознакомления</div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <iframe src="https://www.youtube.com/embed/uCHQ0RXgx_s?si=yNqSkkjb97SULiXb"
                                    style="width: 100%"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                        </div>
                        <div class="col-8">
                            Первое правило картодела, не говори людям как работает их любимая игра,
                            либо они попросят подробнее либо скажут что ты врешь
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <iframe src="https://www.youtube.com/embed/O5x9amc0Xd4?si=DOw3dPfeFNehqY9y"
                                    style="width: 100%"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                        </div>
                        <div class="col-8">
                            Краткий разбор как создавать сценарии и как работают триггеры.
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <iframe src="https://www.youtube.com/embed/odNk7w6qE7Q?si=qvecXZyYwqIMg505"
                                    title="YouTube video player" frameborder="0" style="width: 100%"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                        </div>
                        <div class="col-8">
                            Очень краткий обзор RMSок.
                            <br>
                            Доп материалы:
                            <br>
                            <a href="https://docs.google.com/document/d/1jnhZXoeL9mkRUJxcGlKnO98fIwFKStP_OBozpr0CHXo/edit#heading=h.ehe5dkiu96so">
                                Гайд по рмс
                            </a>
                            <br>
                            <a href="https://docs.google.com/spreadsheets/d/1llyn7FWKEtmss_WE-6hinMItpsV-h-6qsY8xBlkxUzw/edit#gid=0">
                                Константы
                            </a>
                            <a href="https://userpatch.aiscripters.net/unit.ids.html">
                                еще одни
                            </a>
                            <a href="https://userpatch.aiscripters.net/upc.rms.txt">и еще</a>
                            <br>
                            <a href="https://image-to-rms.aoe2.se/">Картинку в карту</a>
                            <br>
                            <a href="https://ugc.aoe2.rocks/">Гайд по XS скриптам</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5" style="display: <?= $aoeIntroTextForMapCreatorViewed ? 'block' : 'none' ?>">
        <h3 class="col-12 text-center intro-again"
            style="color: yellow; font-family:'Droid Sans', arial, verdana, sans-serif; cursor: pointer">
            Покажи еще раз ту крутую заставку как в Звездных войнах
        </h3>
    </div>
</div>
