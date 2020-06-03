<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Response;
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
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function webHookHandlerAction(): Response
    {
        /** @var Update[] $updates */
        $updates = Telegram::getWebhookUpdates();

        foreach ($updates as $update) {
            $this->telegramService->handle($update);
        }

        return response('ok');
    }
}
