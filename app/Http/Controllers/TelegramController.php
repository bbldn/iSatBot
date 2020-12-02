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
    /** @var OrderService */
    protected $orderService;

    /** @var TelegramService */
    protected $telegramService;

    /**
     * TelegramController constructor.
     * @param OrderService $orderService
     * @param TelegramService $telegramService
     */
    public function __construct(
        OrderService $orderService,
        TelegramService $telegramService
    )
    {
        $this->orderService = $orderService;
        $this->telegramService = $telegramService;
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

        if (false === is_numeric( $id)) {
            Log::error(ExceptionFormatter::f('`id` is not number'));

            return response()->json(['ok' => true]);
        }

        $this->orderService->newOrderNotify((int)$id);

        return response()->json(['ok' => true]);
    }
}
