<?php

namespace app\controllers;

use app\models\Map;
use app\models\MapComment;
use app\models\MapCommentLike;
use app\models\MapLike;
use app\models\User;
use Telegram\Bot\Api;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
    public function actions()
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
    public function actionIndex()
    {
        $newMaps = Map::find()->orderBy(['created_at' => 'desc'])->limit(3)->all();
        $someAoe2deMaps = Map::find()->where(['game_id' => 1])->orderBy('RAND()')->limit(3)->all();
        $someWarcraft3Maps = Map::find()->where(['game_id' => 2])->orderBy('RAND()')->limit(3)->all();

        return $this->render('index', [
            'newMaps' => $newMaps,
            'someAoe2deMaps' => $someAoe2deMaps,
            'someWarcraft3Maps' => $someWarcraft3Maps,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionSingUp()
    {
        $post = Yii::$app->request->post();
        if ($post) {

            $model = new User();

            $model->username = $post['User']['username'];
            $model->email = $post['User']['email'];
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($post['User']['password']);

            $model->save();

            Yii::$app->user->login($model);
        }

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();


        $model->password = '';
        return $this->render('sing-up', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionUsers()
    {
        $users = User::find()
            ->joinWith('maps')
            ->where([
                'not',
                ['maps.id' => null]
            ])
            ->all();

        return $this->render('users', ['users' => $users]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionUser()
    {
        $user = User::find()->where(['id' => Yii::$app->request->get('id')])->one();

        return $this->render('user', ['user' => $user]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionMyMaps()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $maps = Yii::$app->user->identity->maps;

        return $this->render('maps', ['maps' => $maps]);
    }

    /**
     * Displays about page.
     *
     * @return Response
     */
    public function actionMyMap()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $map = Yii::$app->user->identity->getMaps()->where(['id' => Yii::$app->request->get('id')])->one();

        return $this->render('map', ['map' => $map]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionMap()
    {
        $map = Map::find()->where(['id' => Yii::$app->request->get('id')])->one();

        return $this->render('map', ['map' => $map]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionMapEdit()
    {
        $map = Map::find()->where(['id' => Yii::$app->request->get('id')])->one();

        return $this->render('map-form', ['map' => $map]);
    }

    /**
     * Displays about page.
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
     * Displays about page.
     *
     * @return string
     */
    public function actionNewMap()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $map = new Map();

        return $this->render('map-form', ['map' => $map]);
    }

    /**
     * Displays about page.
     *
     * @return string
     * @throws HttpException
     */
    public function actionNewMapCreate()
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
            throw new HttpException(200, null);
        }

        throw new HttpException(404, 'No name');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionNewComment()
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

        return $this->renderAjax('_map-comments', ['map' => $map]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionSwitchCommentLikeButton()
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

        return $this->renderAjax('_map-comment-likes', ['comment' => $mapComment]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionSwitchMapLikeButton()
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

        return $this->renderAjax('_map-likes', ['map' => $map]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAoe2de()
    {
        $maps = Map::findAll([
            'game_id' => 1
        ]);

        return $this->render('maps', ['maps' => $maps]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionWarcraft3()
    {
        $maps = Map::findAll([
            'game_id' => 2
        ]);

        return $this->render('maps', ['maps' => $maps]);
    }

    /**
     * Displays about page.
     *
     */
    public function actionUserProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $post = Yii::$app->request->post();
        if ($post) {

            $model = User::findOne(Yii::$app->user->id);

            $model->username = $post['User']['username'];
            $model->description = $post['User']['description'];
            $model->img_url = $post['User']['img_url'];
            $model->save();

            return $this->goHome();
        }

        sleep(1);

        return $this->render('user-profile');
    }

    public function actionGetUserCloseAdWindow()
    {
        if (Yii::$app->user->identity->ad_window_viewed) {
            return null;
        }

        return $this->renderAjax('_ad-window');
    }

    public function actionSetUserCloseAdWindow()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->ad_window_viewed = 1;
        $user->save();
    }
}
