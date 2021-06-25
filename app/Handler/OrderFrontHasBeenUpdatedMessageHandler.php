<?php

namespace App\Handler;

use App\Services\OrderService;
use App\Models\Synchronizer\Order;
use Messenger\OrderFrontHasBeenUpdatedMessage;

class OrderFrontHasBeenUpdatedMessageHandler
{
    private OrderService $orderService;

    /**
     * OrderFrontHasBeenUpdatedMessageHandler constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param OrderFrontHasBeenUpdatedMessage $message
     */
    public function handle(OrderFrontHasBeenUpdatedMessage $message): void
    {
        $order = Order::where(Order::frontId, $message->getId())->first();
        if (null === $order) {
            return;
        }

        $orderBackId = $order->back_id;
        if (null === $orderBackId) {
            return;
        }

        $this->orderService->newOrderNotify((int)$orderBackId);
    }
}