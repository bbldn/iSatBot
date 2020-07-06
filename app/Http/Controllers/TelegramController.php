<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramController extends Controller
{
    /** @var TelegramService $telegramService */
    protected $telegramService;

    /**
     * TelegramController constructor.
     * @param TelegramService $telegramService
     */
    public function __construct(TelegramService $telegramService)
    {
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
    public function newOrderNotify(Request $request): Response
    {
        $id = (int)$request->get('id', -1);

        return response()->json(['ok' => true]);
    }
}
