<?php

namespace App\Services;

use App\Chat;
use App\Events\EventList;
use App\Helpers\EventListeners;
use Illuminate\Support\Collection;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramResponseException;

class OrderService extends Service
{
    /** @var GetOrderInformationInterface */
    private $getOrderInformation;

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
     * @throws TelegramResponseException
     */
    public function newOrderNotify(int $id): void
    {
        $chats = EventListeners::getChatsByEvent(EventList::ORDER_NEW);
        if (true === $chats->isEmpty()) {
            return;
        }

        $texts = $this->getOrderInformation->getOrderInformation($id);

        foreach ($chats as $chat) {
            /** @var Chat $chat */
            foreach ($texts as $text) {
                try {
                    /** @noinspection PhpUndefinedMethodInspection */
                    Telegram::sendMessage([
                        'chat_id' => $chat->chat_id,
                        'text' => $text,
                        'parse_mode' => 'HTML',
                    ]);
                } catch (TelegramResponseException $e) {
                    if (true !== is_numeric($e->getCode()) || 403 !== (int)$e->getCode()) {
                        throw $e;
                    }
                }
            }
        }
    }
}
