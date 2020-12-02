<?php

namespace App\Console;

use App\Helpers\ExceptionFormatter;
use App\Services\OrderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendOrderCommand extends Command
{
    /** @var string */
    protected $signature = 'telegram:order:send {orderId}';

    /** @var string */
    protected $description = 'Send notification about order';

    /**
     * @param OrderService $orderService
     */
    public function handle(OrderService $orderService): void
    {
        $id = $this->argument('orderId');
        if (null === $id) {
            Log::error(ExceptionFormatter::f('`id` not found'));
        }

        if (0 === is_numeric($id)) {
            Log::error(ExceptionFormatter::f('`id` is not number'));
        }

        $orderService->newOrderNotify((int)$id);
    }
}
