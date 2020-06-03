<?php

namespace App\Services;

use App\Activities\Activity;
use App\Activities\LoginActivity;
use App\Activities\StartActivity;
use App\Chat;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramService extends Service
{
    /** @var string[] $activities */
    protected $activities = [
        LoginActivity::class,
    ];

    /**
     * @param Update $update
     */
    public function authorization(Update $update): void
    {
        /** @var Chat|null $chat */
        $chat = Chat::where('chat_id', $update->getMessage()->getChat()->getId())->first();
        if (null === $chat) {
            return;
        }

        if (null !== $chat->user) {
            $chat->user->chat = $chat;
            Auth::setUser($chat->user);
        }
    }

    /**
     * @param Update $update
     */
    public function handle(Update $update): void
    {
        $this->authorization($update);

        $processed = false;
        foreach ($this->activities as $activity) {
            if (true === $activity::able($update)) {
                /** @var Activity $obj */
                $obj = new $activity();
                $processed = $obj->handle($update);
            }

            if (true === $processed) {
                break;
            }
        }

        if (false === $processed) {
            Telegram::sendMessage([
                'chat_id' => $update->getMessage()->getChat()->getId(),
                'text' => 'Неизвестная комманд ' . $update->getMessage()->getText(),
            ]);
        }
    }
}
