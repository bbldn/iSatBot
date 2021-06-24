<?php

namespace App\Helpers;

use App\Chat;

class ChatKeeper
{
    private ?Chat $chat = null;

    private static ?ChatKeeper $instance = null;

    /**
     * ChatKeeper constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return ChatKeeper
     */
    public static function instance(): ChatKeeper
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @return Chat|null
     */
    public function getChat(): ?Chat
    {
        return $this->chat;
    }

    /**
     * @param Chat|null $chat
     * @return ChatKeeper
     */
    public function setChat(?Chat $chat): ChatKeeper
    {
        $this->chat = $chat;

        return $this;
    }
}