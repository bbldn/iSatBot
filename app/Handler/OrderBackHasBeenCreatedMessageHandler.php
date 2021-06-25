<?php

namespace App\Handler;

use App\Services\OrderService;
use Messenger\OrderBackHasBeenCreatedMessage;

class OrderBackHasBeenCreatedMessageHandler
{
    private OrderService $orderService;

    /**
     * OrderBackHasBeenCreatedMessageHandler constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param OrderBackHasBeenCreatedMessage $message
     */
    public function handle(OrderBackHasBeenCreatedMessage $message): void
    {
        $this->orderService->orderCreatedNotify((int)$message->getId());
    }
}