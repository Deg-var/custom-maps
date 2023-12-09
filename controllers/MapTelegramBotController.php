<?php

namespace app\controllers;

use app\models\Game;
use app\models\Map;
use app\models\MapComment;
use app\models\MapCommentLike;
use app\models\MapLike;
use app\models\User;
use JetBrains\PhpStorm\NoReturn;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
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

//        dd(json_decode('{"update_id":201023435,"message":{"message_id":69,"from":{"id":544792213,"is_bot":false,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440","last_name":"\u041c\u0443\u0440\u0430\u0448\u0435\u0432","username":"Degvar","language_code":"ru","is_premium":true},"chat":{"id":544792213,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440","last_name":"\u041c\u0443\u0440\u0430\u0448\u0435\u0432","username":"Degvar","type":"private"},"date":1702101851,"text":"7777","entities":[{"offset":0,"length":4,"type":"text_link","url":"https:\/\/vk.com\/deg_var"}]}}'));

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
     * @throws TelegramSDKException
     */
    public function actionGetMassage()
    {
        $myBot = new Api(Yii::$app->params['token']);

        $input = $myBot->getWebhookUpdate();

        $massage = $input->getMessage();

        if ($massage->text === '/get_rand_aoe_map') {
            /** @var Map $map */
            $game = Game::findOne(Game::AOE2DE);
            $map = Map::find()->where(['game_id' => $game->id])->orderBy('RAND()')->one();

            $text = 'Карта от ' . $map->user->username . "\n" . $map->name . "\n" . $map->description . "\n"
                . 'https://custom-maps.site/site/map?id=' . $map->id;

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $map->img_link ?? $game->default_img_url,
            ]);

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $text,
            ]);
        }

        if ($massage->text === '/get_rand_w3_map') {
            /** @var Map $map */
            $game = Game::findOne(Game::WARCRAFT3);
            $map = Map::find()->where(['game_id' => $game->id])->orderBy('RAND()')->one();

            $text = 'Карта от ' . $map->user->username . "\n" . $map->name . "\n" . $map->description . "\n"
                . 'https://custom-maps.site/site/map?id=' . $map->id;

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $map->img_link ?? $game->default_img_url,
            ]);

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $text,
            ]);
        }

//        $myBot->sendMessage([
//            'chat_id'=>$massage->from->id,
//            'text'=>json_encode($massage)
//            ]);

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
