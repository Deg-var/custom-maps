<?php

namespace app\controllers;

use app\models\BotUser;
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
//        dd(json_decode('{"message_id":143,"from":{"id":544792213,"is_bot":false,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440","last_name":"\u041c\u0443\u0440\u0430\u0448\u0435\u0432","username":"Degvar","language_code":"ru","is_premium":true},"chat":{"id":544792213,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440","last_name":"\u041c\u0443\u0440\u0430\u0448\u0435\u0432","username":"Degvar","type":"private"},"date":1702195531,"reply_to_message":{"message_id":141,"from":{"id":6882718645,"is_bot":true,"first_name":"\u0421\u0430\u0439\u0442 \u043a\u0430\u0441\u0442\u043e\u043c\u043e\u043a \u043e\u0442 Pankyxaa","username":"custom_maps_bot"},"chat":{"id":544792213,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0430\u043d\u0434\u0440","last_name":"\u041c\u0443\u0440\u0430\u0448\u0435\u0432","username":"Degvar","type":"private"},"date":1702184215,"text":"\u041a\u0430\u0440\u0442\u0430 \u043e\u0442 Pankyxaa\nLIKE WARHAMMER 40K DOW\n\u0414\u0432\u0435 \u043a\u0430\u0440\u0442\u044b \u0441 \u043c\u0435\u0445\u0430\u043d\u0438\u043a\u043e\u0439 \u0437\u0430\u0445\u0432\u0430\u0442\u0430 \u0442\u043e\u0447\u0435\u043a \u043a\u0430\u043a \u0432 \u0438\u0433\u0440\u0430\u0445 \u0440\u0435\u043b\u0438\u043a\u043e\u0432\n\u0421\u0441\u044b\u043b\u043a\u0430 \u043d\u0430 \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0443 \u043d\u0430 \u0441\u0430\u0439\u0442\u0435 - https:\/\/custom-maps.site\/site\/map\/12","entities":[{"offset":127,"length":36,"type":"url"}]},"text":"88888"}'));
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
            $botUser = BotUser::findOne(['chat_id' => $massage->from->id]);

            if ($botUser) {
                $myBot->sendMessage([
                    'chat_id' => $massage->from->id,
                    'text' => 'Напиши реплаем свою идею, а я запишу.',
                ]);
            } else {
                $myBot->sendMessage([
                    'chat_id' => $massage->from->id,
                    'text' => 'Напиши реплаем как тебя представить боссу😎',
                ]);
            }
        }

        if ($massage->reply_to_message->text === 'Напиши реплаем свою идею, а я запишу.') {
            $botUser = BotUser::findOne(['chat_id' => $massage->from->id]);
            $botUser->idea = $massage->text;
            $botUser->save();

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => 'Записал, передам',
            ]);
        }

        if ($massage->reply_to_message->text === 'Напиши реплаем как тебя представить боссу😎') {
            $botUser = new BotUser();
            $botUser->chat_id = $massage->from->id;
            $botUser->name = $massage->text;
            $botUser->save();

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => $massage->text . ', так и запишем...',
            ]);

            $myBot->sendMessage([
                'chat_id' => $massage->from->id,
                'text' => 'Напиши реплаем как тебя представить боссу😎',
            ]);
        }

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
