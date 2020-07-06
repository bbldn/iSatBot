<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class SearchActivity extends Activity
{
    /** @var OrderService $orderService */
    protected $orderService;

    /**
     * SearchActivity constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        if (null === Auth::user()) {
            return false;
        }

        if (Actions::MENU !== ChatKeeper::instance()->getChat()->data->get('action')) {
            return false;
        }

        return 1 === preg_match('/^\#[0-9]+$/', $update->getMessage()->getText());
    }


    /**
     * @param Update $update
     * @return int
     */
    public function handle(Update $update): int
    {
        preg_match('/^\#([0-9]+)$/', $update->getMessage()->getText(), $arr);
        $id = (int)$arr[1];

        $texts = $this->orderService->getOrderInformation($id);

        foreach ($texts as $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => ChatKeeper::instance()->getChat()->chat_id,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);
        }

        return Activity::SUCCESS;
    }
}
