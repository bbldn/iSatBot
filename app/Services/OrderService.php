<?php

namespace App\Services;

use App\Helpers\EventList;
use App\Helpers\EventListeners;
use Illuminate\Support\Collection;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrderService
{
    private GetOrderInformationInterface $getOrderInformation;

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
     * @return Collection
     */
    public function getOrderInformation(int $id): Collection
    {
        return $this->getOrderInformation->getOrderInformation($id);
    }

    /**
     * @param int $id
     */
    public function orderCreatedNotify(int $id): void
    {
        $chats = EventListeners::getChatsByEvent(EventList::ORDER_NEW);
        if (true === $chats->isEmpty()) {
            return;
        }

        $texts = $this->getOrderInformation->getOrderInformation($id);

        foreach ($chats as $chat) {
            foreach ($texts as $text) {
                /** @noinspection PhpUndefinedMethodInspection */
                Telegram::sendMessage([
                    'text' => $text,
                    'parse_mode' => 'HTML',
                    'chat_id' => $chat->chat_id,
                ]);
            }
        }
    }
}