<?php

namespace app\controllers;

use app\models\BotUser;
use app\models\Map;
use app\models\MapComment;
use app\models\MapCommentLike;
use app\models\MapLike;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Throwable;
use Yii;
use yii\data\Pagination;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $newMaps = Map::find()->limit(3)->orderBy(['id' => SORT_DESC])->all();
        $someAoe2deMaps = Map::find()->where(['game_id' => 1])->orderBy('RAND()')->limit(3)->all();
        $someWarcraft3Maps = Map::find()->where(['game_id' => 2])->orderBy('RAND()')->limit(3)->all();

        return $this->render('index', [
            'newMaps' => $newMaps,
            'someAoe2deMaps' => $someAoe2deMaps,
            'someWarcraft3Maps' => $someWarcraft3Maps,
        ]);
    }

    /**
     * Карты текущего пользователя
     *
     * @return string|Response
     */
    public function actionMyMaps(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $query = Map::find()->where(['user_id' => Yii::$app->user->id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $maps = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('maps', [
            'maps' => $maps,
            'pages' => $pages,
        ]);
    }

    /**
     * Одна карта
     *
     * @return string
     */
    public function actionMap($id): string
    {
        $map = Map::findOne($id);

        return $this->render('map', ['map' => $map]);
    }

    /**
     * Форма редактирование карты
     *
     * @return Response|string
     */
    public function actionMapEdit($id): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $map = Map::findOne($id);

        return $this->render('map-form', ['map' => $map]);
    }

    /**
     * Редактирование карты
     *
     * @return Response
     * @throws HttpException
     */
    public function actionMapEditSubmit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $post = Yii::$app->request->post();

        if ($post['name']) {
            $map = Map::findOne($post['id']);
            $map->name = $post['name'];
            $map->description = $post['description'];
            $map->img_link = $post['img_link'];
            $map->video_link = $post['video_link'];
            $map->mod_link = $post['mod_link'];
            $map->game_id = $post['game_id'];
            $map->save();
            throw new HttpException(200, null);
        }

        throw new HttpException(404, 'No name');
    }

    /**
     * Удаление карты
     *
     * @return Response
     * @throws HttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDeleteMap(): Response
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $map = Map::findOne(Yii::$app->request->post('mapId'));

        if ($map?->user?->id == Yii::$app->user->id) {
            $map->delete();

            throw new HttpException(200, null);
        }

        return $this->goHome();
    }

    /**
     * Форма создания новой карты
     *
     * @return Response|string
     */
    public function actionNewMap(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $map = new Map();

        return $this->render('map-form', ['map' => $map]);
    }

    /**
     * Создание новой карты
     *
     * @return Response
     * @throws HttpException
     * @throws TelegramSDKException
     */
    public function actionNewMapCreate(): Response
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $post = Yii::$app->request->post();

        if ($post['name']) {
            $map = new Map();
            $map->name = $post['name'];
            $map->description = $post['description'];
            $map->img_link = $post['img_link'];
            $map->video_link = $post['video_link'];
            $map->mod_link = $post['mod_link'];
            $map->game_id = $post['game_id'];
            $map->user_id = Yii::$app->user->id;
            $map->save();

            $botUsers = BotUser::find()
                ->select(['chat_id'])
                ->where(['get_new_maps' => 1])
                ->distinct('chat_id')
                ->all();

            if (count($botUsers)) {
                $myBot = new Api(Yii::$app->params['token'], true);

                foreach ($botUsers as $botUser) {
                    /** @var BotUser $botUser */
                    $text = 'Карта от ' . $map->user?->username . "\n" . $map->name . "\n" . $map->description . "\n"
                        . 'Ссылка на страницу на сайте - https://custom-maps.site/map/' . $map->id;

                    $myBot->sendMessage([
                        'chat_id' => $botUser->chat_id,
                        'text' => $map->img_link ?? $map->game?->default_img_url,
                    ]);

                    $myBot->sendMessage([
                        'chat_id' => $botUser->chat_id,
                        'text' => $text,
                    ]);

                    $myBot->sendMessage([
                        'chat_id' => $botUser->chat_id,
                        'text' => 'Ссылка на мод ' . $map->mod_link,
                    ]);
                }
            }


            throw new HttpException(200, null);
        }

        throw new HttpException(404, 'No name');
    }

    /**
     * Новый коммент
     *
     * @return Response|string
     */
    public function actionNewComment(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $post = Yii::$app->request->post();

        $newComment = new MapComment();
        $newComment->user_id = Yii::$app->user->id;
        $newComment->map_id = $post['mapId'];
        $newComment->text = $post['commentText'];
        $newComment->save();

        $map = Map::findOne($post['mapId']);

        return $this->renderAjax('../common-components/_map-comments', ['map' => $map]);
    }

    /**
     * Нажатие на кнопку лайка комментария
     *
     * @return string|Response
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionSwitchCommentLikeButton(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $post = Yii::$app->request->post();

        $commentLike = MapCommentLike::find()->where([
            'user_id' => Yii::$app->user->id,
            'comment_id' => $post['commentId'],
        ])
            ->one();

        if ($commentLike) {
            $commentLike->delete();
        } else {
            $commentLike = new MapCommentLike();
            $commentLike->comment_id = $post['commentId'];
            $commentLike->user_id = Yii::$app->user->id;
            $commentLike->save();
        }

        $mapComment = MapComment::findOne($post['commentId']);

        return $this->renderAjax('../common-components/_map-comment-likes', ['comment' => $mapComment]);
    }

    /**
     * Нажатие не кнопку лайка
     *
     * @return Response|string
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionSwitchMapLikeButton(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $post = Yii::$app->request->post();

        $mapLike = MapLike::find()->where([
            'user_id' => Yii::$app->user->id,
            'map_id' => $post['mapId'],
        ])->one();

        if ($mapLike) {
            $mapLike->delete();
        } else {
            $mapLike = new MapLike();
            $mapLike->map_id = $post['mapId'];
            $mapLike->user_id = Yii::$app->user->id;
            $mapLike->save();
        }

        $map = Map::findOne($post['mapId']);

        return $this->renderAjax('../common-components/_map-likes', ['map' => $map]);
    }

    /**
     * Список карт по эпохе
     *
     * @return string
     */
    public function actionAoe2de(): string
    {
        $query = Map::find()->where(['game_id' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $maps = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('maps', [
            'maps' => $maps,
            'pages' => $pages,
        ]);
    }

    /**
     * Список карт по варику
     *
     * @return string
     */
    public function actionWarcraft3(): string
    {
        $query = Map::find()->where(['game_id' => 2]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $maps = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('maps', [
            'maps' => $maps,
            'pages' => $pages,
        ]);
    }
}
