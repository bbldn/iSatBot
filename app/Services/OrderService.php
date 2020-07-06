<?php

namespace App\Services;

use App\Chat;
use App\Events\EventList;
use App\Helpers\EventListeners;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrderService extends Service
{
    /** @var GetOrderInformationInterface $getOrderInformation */
    protected $getOrderInformation;

    /**
     * OrderService constructor.
     * @param GetOrderInformationInterface $getOrderInformation
     */
    public function __construct(GetOrderInformationInterface $getOrderInformation)
    {
        $this->getOrderInformation = $getOrderInformation;
    }

    /**
     * @param int $id
     * @return string[]
     */
    public function getOrderInformation(int $id): array
    {
        return $this->getOrderInformation->getOrderInformation($id);
    }

    /**
     * @param int $id
     */
    public function newOrderNotify(int $id): void
    {
        $chats = EventListeners::getChatsByEvent(EventList::ORDER_NEW);
        if (true === $chats->isEmpty()) {
            return;
        }

        $texts = $this->getOrderInformation->getOrderInformation($id);

        foreach ($chats as $chat) {
            foreach ($texts as $text) {
                /** @noinspection PhpUndefinedMethodInspection */
                /** @var Chat $chat */
                Telegram::sendMessage([
                    'chat_id' => $chat->chat_id,
                    'text' => $text,
                    'parse_mode' => 'HTML',
                ]);
            }
        }
    }
}
