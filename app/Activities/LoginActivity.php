<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use Telegram\Bot\Objects\Update;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Exceptions\WrongActionException;
use Telegram\Bot\Laravel\Facades\Telegram;

class LoginActivity extends Activity
{
    private UserRepository $userRepository;

    /**
     * LoginActivity constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
        $text = $update->getMessage()->text;
        $chat = ChatKeeper::instance()->getChat();
        $user = $this->userRepository->findOneByLogin($text);

        if (null === $user) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => "Неизвестный логин: {$text}. Попробуйте ещё раз:",
            ]);

            return Activity::SUCCESS;
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

        $user = $this->userRepository->find((int)$chat->data->get('user_id', 0));
        if (null === $user) {
            $update->put('message', $update->getMessage()->put('text', '/start'));
            $chat->data = collect();
            $chat->save();

            return Activity::RECYCLE;
        }

        if (false === Hash::check($update->getMessage()->text, $user->password)) {
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