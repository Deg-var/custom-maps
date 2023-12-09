<?php

namespace app\controllers;

use app\models\Map;
use app\models\MapComment;
use app\models\MapCommentLike;
use app\models\MapLike;
use app\models\User;
use JetBrains\PhpStorm\NoReturn;
use Telegram\Bot\Api;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use TelegramBot\Api\InvalidArgumentException;
use TelegramBot\Api\Types\Update;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class MapTelegramBotController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * @throws \TelegramBot\Api\Exception
     * @throws \Exception
     */
    public function actionSetWebhook()
    {
        $myBot = new BotApi(Yii::$app->params['token']);
        $myBot->setWebhook('https://custom-maps.site/map-telegram-bot/get-massage');
        sleep(5);
        dd($myBot->getWebhookInfo());
    }

    /**
     * @throws \TelegramBot\Api\Exception
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function actionWebhookInfo()
    {
        $myBot = new BotApi(Yii::$app->params['token']);
        dd($myBot->getWebhookInfo());
    }

    /**
     * @throws \TelegramBot\Api\Exception
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function actionGetMassage()
    {
        $myBot = new Client(Yii::$app->params['token']);

        //Handle text messages
        $myBot->on(function (Update $update) use ($myBot) {
            $message = $update->getMessage();
            $id = $message->getChat()->getId();
            $myBot->sendMessage($id, 'Your message: ' . $message->getText());
        }, function () {
            return true;
        });

        return true;
    }

    /**
     * @throws \TelegramBot\Api\Exception
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function actionSendMassage()
    {
        $myBot = new BotApi(Yii::$app->params['token']);

        $myBot->sendMessage(
            544792213,
            json_encode(Yii::$app->request->get())
        );

        return $this->goHome();
    }


}
