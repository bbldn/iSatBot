<?php

namespace App\Activities;

use App\Exceptions\WrongActionException;
use App\Helpers\ChatKeeper;
use App\User;
use Illuminate\Support\Facades\Hash;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class LoginActivity extends Activity
{
    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        $chat = ChatKeeper::instance()->getChat();

        if (null === $chat) {
            return false;
        }

        if (false === key_exists('action', $chat->data)) {
            return false;
        }

        if (false === in_array($chat->data['action'], [Actions::INPUT_LOGIN, Actions::INPUT_PASSWORD])) {
            return false;
        }

        return true;
    }

    /**
     * @param Update $update
     * @return int
     * @throws WrongActionException
     */
    public function handle(Update $update): int
    {
        $action = ChatKeeper::instance()->getChat()->data['action'];
        if (Actions::INPUT_LOGIN === $action) {
            return $this->login($update);
        } elseif (Actions::INPUT_PASSWORD === $action) {
            return $this->password($update);
        }

        throw new WrongActionException("Wrong action {$action}");
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function login(Update $update): int
    {
        $text = $update->getMessage()->getText();
        $user = User::where('login', $text)->first();

        if (null === $user) {
            Telegram::sendMessage([
                'chat_id' => $update->getMessage()->getChat()->getId(),
                'text' => "Неизвестный логин: {$text}",
            ]);

            $update->getMessage()->replace(['text' => '/start']);

            return Activity::RECYCLE;
        }

        $chat = ChatKeeper::instance()->getChat();
        $chat->data['action'] = Actions::INPUT_PASSWORD;
        $chat->data['user_id'] = $user->id;
        $chat->save();

        Telegram::sendMessage([
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text' => "Здравствуйте {$user->name}, введите пароль:",
        ]);

        return Activity::SUCCESS;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function password(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        if (false === key_exists('user_id', $chat->data)) {
            $update->getMessage()->replace(['text' => '/start']);
            $chat->data = [];
            $chat->save();

            return Activity::RECYCLE;
        }

        $user = User::find($chat->data['user_id']);
        if (null === $user) {
            $update->getMessage()->replace(['text' => '/start']);
            $chat->data = [];
            $chat->save();

            return Activity::RECYCLE;
        }

        if (false === Hash::check($update->getMessage()->getText(), $user->password)) {
            Telegram::sendMessage([
                'chat_id' => $update->getMessage()->getChat()->getId(),
                'text' => 'Неверный пароль. Попробуйте ввести ещё раз:',
            ]);

            return Activity::SUCCESS;
        }

        Telegram::sendMessage([
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text' => 'Спасибо за авторизацию!',
        ]);

        unset($chat->data['user_id']);
        $chat->save();

        $update->getMessage()->replace(['text' => 'Меню']);

        return Activity::RECYCLE;
    }
}
