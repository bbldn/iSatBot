<?php

namespace App\Services;

use App\Activities\Activity;
use App\Activities\LoginActivity;
use App\Activities\MenuActivity;
use App\Activities\SettingActivity;
use App\Activities\StartActivity;
use App\Chat;
use App\Helpers\ChatKeeper;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramService extends Service
{
    /** @var string[] $activities */
    protected $activities = [
        StartActivity::class,
        LoginActivity::class,
        MenuActivity::class,
        SettingActivity::class,
    ];

    /**
     * @param Update $update
     */
    public function authorization(Update $update): void
    {
        $chatId = $update->getMessage()->getChat()->getId();

        /** @var Chat|null $chat */
        $chat = Chat::where('chat_id', $chatId)->first();
        if (null === $chat) {
            $attributes = [
                'chat_id' => $chatId,
                'data' => collect(),
                'user' => null,
            ];
            ChatKeeper::instance()->setChat(new Chat($attributes));

            return;
        }

        ChatKeeper::instance()->setChat($chat);

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

        $status = Activity::FAIL;
        while (true) {
            $cycle = false;
            foreach ($this->activities as $activity) {
                if (true === $activity::able($update)) {
                    /** @var Activity $obj */
                    $obj = new $activity();
                    $status = $obj->handle($update);
                    if (Activity::SUCCESS === $status) {
                        break;
                    } elseif (Activity::RECYCLE === $status) {
                        $cycle = true;
                        break;
                    }
                }
            }

            if (false === $cycle) {
                break;
            }
        }


        if (Activity::FAIL === $status) {
            Telegram::sendMessage([
                'chat_id' => $update->getMessage()->getChat()->getId(),
                'text' => 'Неизвестная комманд ' . $update->getMessage()->getText(),
            ]);
        }
    }
}
