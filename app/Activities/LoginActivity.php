<?php

namespace App\Activities;

use App\Exceptions\WrongActionException;
use App\Helpers\ChatKeeper;
use App\User;
use Illuminate\Support\Facades\Auth;
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

        if (false === $chat->data->has('action')) {
            return false;
        }

        if (false === in_array($chat->data->get('action'), [Actions::INPUT_LOGIN, Actions::INPUT_PASSWORD])) {
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
        $action = ChatKeeper::instance()->getChat()->data->get('action');
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
        $chat = ChatKeeper::instance()->getChat();
        $text = $update->getMessage()->getText();
        $user = User::where('login', $text)->first();

        if (null === $user) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => "Неизвестный логин: {$text}. Попробуйте ещё раз:",
            ]);

            $update->put('message', $update->getMessage()->put('text', '/start'));

            return Activity::RECYCLE;
        }

        $chat->data->put('action', Actions::INPUT_PASSWORD);
        $chat->data->put('user_id', $user->id);
        $chat->save();

        /** @noinspection PhpUndefinedMethodInspection */
        Telegram::sendMessage([
            'chat_id' => $chat->chat_id,
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
        if (false === $chat->data->has('user_id')) {
            $update->put('message', $update->getMessage()->put('text', '/start'));
            $chat->data = collect();
            $chat->save();

            return Activity::RECYCLE;
        }

        $user = User::find((int)$chat->data->get('user_id', 0));
        if (null === $user) {
            $update->put('message', $update->getMessage()->put('text', '/start'));
            $chat->data = collect();
            $chat->save();

            return Activity::RECYCLE;
        }

        if (false === Hash::check($update->getMessage()->getText(), $user->password)) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Неверный пароль. Попробуйте ввести ещё раз:',
            ]);

            return Activity::SUCCESS;
        }

        /** @noinspection PhpUndefinedMethodInspection */
        Telegram::sendMessage([
            'chat_id' => $chat->chat_id,
            'text' => 'Спасибо за авторизацию!',
        ]);

        $chat->data->put('action', Actions::MENU);
        $chat->data->forget('user_id');
        $chat->user_id = $user->id;
        $chat->save();

        Auth::setUser($user);

        $update->put('message', $update->getMessage()->put('text', 'Меню'));

        return Activity::RECYCLE;
    }
}
