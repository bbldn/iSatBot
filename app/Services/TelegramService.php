<?php

namespace App\Services;

use App\Models\Chat;
use App\Helpers\ChatKeeper;
use App\Activities\Activity;
use App\Activities\MenuActivity;
use Telegram\Bot\Objects\Update;
use App\Activities\LoginActivity;
use App\Activities\StartActivity;
use App\Activities\SearchActivity;
use App\Activities\SettingActivity;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramService
{
    /** @psalm-var list<class-string> */
    private $activities = [
        StartActivity::class,
        LoginActivity::class,
        SearchActivity::class,
        MenuActivity::class,
        SettingActivity::class,
    ];

    /**
     * @param Update $update
     */
    public function authorization(Update $update): void
    {
        $chatId = $update->getMessage()->chat->id;

        /** @var Chat|null $chat */
        $chat = Chat::where('chat_id', $chatId)->first();
        if (null === $chat) {
            $attributes = [
                'user' => null,
                'data' => collect(),
                'chat_id' => $chatId,
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
                    $obj = app()->make($activity);
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
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $update->getMessage()->chat->id,
                'text' => "Неизвестная комманда: {$update->getMessage()->text}",
            ]);
        }
    }
}