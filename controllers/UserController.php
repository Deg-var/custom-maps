<?php

namespace app\controllers;

use app\models\Map;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class UserController extends Controller
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
     * Displays about page.
     *
     * @return string
     */
    public function actionMapCreators()
    {
        $users = User::find()
            ->joinWith('maps')
            ->where([
                'not',
                ['maps.id' => null]
            ])
            ->all();

        return $this->render('map-creators', ['users' => $users]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionUser($id)
    {
        $user = User::find()->where(['id' => $id])->one();

        return $this->render('user', ['user' => $user]);
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
        if (Yii::$app->user->isGuest) {
            return null;
        }

        $user = User::findOne(Yii::$app->user->id);
        $user->ad_window_viewed = 1;
        $user->save();
    }
}
