<?php

use app\assets\MapAsset;
use app\models\Map;
use app\models\User;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\bootstrap5\ActiveForm $form
 * @var User $user
 * @var Map $map
 */

MapAsset::register($this);

$this->title = $map->name ?? 'Новая карта';
$this->params['breadcrumbs'][] = $map->name ?? 'Новая карта';

?>

<div class="site">
    <?php $form = ActiveForm::begin([
        'id' => 'newMap',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?= $form->field($map, 'game_id')->dropDownList([1 => 'AoE2DE', 2 => 'Warcraft 3'], ['id' => 'mapGameId']) ?>
    <?= $form->field($map, 'name')->textInput(['id' => 'mapName']) ?>
    <?= $form->field($map, 'description')->textarea(['id' => 'mapDescription']) ?>
    <?= $form->field($map, 'img_link')->textInput(['id' => 'mapImgLink']) ?>
    <?= $form->field($map, 'video_link')->textInput(['id' => 'mapVideoLink']) ?>
    <?= $form->field($map, 'mod_link')->textInput(['id' => 'mapModLink']) ?>

    <div class="form-group row">
        <div class="col">
            <?= Html::button('Сохранить', [
                'class' => 'btn btn-primary',
                'id' => 'submitNewMap',
                'data-is-new' => $map->id ? 'false' : 'true',
                'data-map-id' => $map->id
            ]) ?>
        </div>
        <div class="col text-end">
            <span class="loader" style="display: none"></span>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
