<?php

use app\models\Map;
use app\models\MapComment;
use yii\helpers\ArrayHelper;

/**
 * @var Map $map
 */

?>
<?php foreach ($map->comments as $key => $comment): ?>
    <?php /* @var MapComment $comment */ ?>
    <div class="row border border-1 mb-1 pt-2 pb-2"
         style="background-color:<?= fmod($key, 2) ? 'deepskyblue' : 'lightblue'; ?>;">
        <div class="col-2">
            <img src="<?= $comment->user->img_url ?>" alt="" style="height: 10vh">
        </div>
        <div class="col-10">
            <h4><?= $comment->user->username ?></h4>
            <p><?= $comment->text ?></p>
        </div>
        <div class="col-12 text-end">
            <div class="forLikes" id="commentId-<?= $comment->id ?>">
                <?= $this->render('_map-comment-likes', ['comment' => $comment]) ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>