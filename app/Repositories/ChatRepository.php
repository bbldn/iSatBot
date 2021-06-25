<?php

namespace App\Repositories;

use App\Models\Chat;

class ChatRepository
{
    /**
     * @param string|null $chatId
     * @return Chat|null
     */
    public function findOneByChatId(?string $chatId): ?Chat
    {
        /** @var Chat|null $chat */
        $chat = Chat::where(Chat::chatId, $chatId)->first();

        return $chat;
    }
}