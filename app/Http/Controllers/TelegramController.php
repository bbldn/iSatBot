<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionFormatter;
use App\Services\OrderService;
use App\Services\TelegramService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramController extends Controller
{
    /** @var TelegramService $telegramService */
    protected $telegramService;

    /** @var OrderService $orderService */
    protected $orderService;

    /**
     * TelegramController constructor.
     * @param TelegramService $telegramService
     * @param OrderService $orderService
     */
    public function __construct(TelegramService $telegramService, OrderService $orderService)
    {
        $this->telegramService = $telegramService;
        $this->orderService = $orderService;
    }

    /**
     * @return ResponseFactory|Response
     * @throws BindingResolutionException
     */
    public function webHookHandlerAction(): Response
    {
        $offset = Cache::get('offset', 0);

        /** @noinspection PhpUndefinedMethodInspection */
        /** @var Update $update */
        $update = Telegram::getWebhookUpdates(['offset' => $offset + 1]);
        $this->telegramService->handle($update);

        Cache::put('offset', $update->getUpdateId());

        return response('ok');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function newOrderNotifyAction(Request $request): Response
    {
        $id = $request->get('id');
        if (null === $id) {
            Log::error(ExceptionFormatter::f('`id` not found'));

            return response()->json(['ok' => true]);
        }

        if (0 === preg_match('/^[0-9]+$/', $id)) {
            Log::error(ExceptionFormatter::f('`id` is not number'));

            return response()->json(['ok' => true]);
        }

        sleep(5);

        $this->orderService->newOrderNotify((int)$id);

        return response()->json(['ok' => true]);
    }
}
