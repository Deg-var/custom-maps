<?php

namespace app\controllers;

use app\models\BotUsersIdeas;
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

        if ($massage->text === '/start') {
            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => 'Дратвуйте, мы все тут рады что вы пришли!' . "\n"
                    . 'Тыкните команды чтоб посмотреть наше сокровище' . "\n" . "\n"
                    . '/get_rand_w3_map - Случайная карта по Варику' . "\n"
                    . '/get_rand_aoe_map - Случайная карта по Эпохе',
            ]);
        }

        if ($massage->text === '/get_rand_aoe_map') {
            /** @var Map $map */
            $game = Game::findOne(Game::AOE2DE);
            $map = Map::find()->where(['game_id' => $game->id])->orderBy('RAND()')->one();

            $text = 'Карта от ' . $map->user->username . "\n" . $map->name . "\n" . $map->description . "\n"
                . 'Ссылка на страницу на сайте - https://custom-maps.site/site/map/' . $map->id;

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $map->img_link ?? $game->default_img_url,
            ]);

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $text,
            ]);

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => 'Ссылка на мод ' . $map->mod_link,
            ]);
        }

        if ($massage->text === '/get_rand_w3_map') {
            /** @var Map $map */
            $game = Game::findOne(Game::WARCRAFT3);
            $map = Map::find()->where(['game_id' => $game->id])->orderBy('RAND()')->one();

            $text = 'Карта от ' . $map->user->username . "\n" . $map->name . "\n" . $map->description . "\n"
                . ' Ссылка на страницу на сайте - https://custom-maps.site/site/map/' . $map->id;

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $map->img_link ?? $game->default_img_url,
            ]);

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $text,
            ]);

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => 'Ссылка на мод ' . $map->mod_link,
            ]);
        }

        if ($massage->text === '/send-idea') {
            $botUser = BotUsersIdeas::findOne(['chat_id' => $massage->from->id]);

            if ($botUser) {
                $myBot->sendMessage([
                    'chat_id' => $massage->from->id,
                    'text' => 'Напиши реплаем свою идею, а запишу.',
                ]);
            } else {
                $myBot->sendMessage([
                    'chat_id' => $massage->from->id,
                    'text' => 'Напиши реплаем как тебя представить боссу😎',
                ]);
            }
        }

        $myBot->sendMessage([
            'chat_id' => $massage->from->id,
            'text' => json_encode($massage),
        ]);

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
