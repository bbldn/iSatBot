<?php

namespace App\Activities;

use App\Chat;
use App\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class StartActivity extends Activity
{
    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (null === $user) {
            return true;
        }

        if (null === $user->chat) {
            return true;
        }

        return false;
    }

    /**
     * @param Update $update
     * @return bool
     */
    public function handle(Update $update): bool
    {
        $chatId = $update->getMessage()->getChat()->getId();
        Chat::create([
            'chat_id' => $chatId,
            'data' => json_encode(['action' => 'input-login']),
            'user_id' => null,
        ]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Введите логин',
        ]);

        return true;
    }
}
