<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use App\Services\OrderService;
use Telegram\Bot\Objects\Update;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class SearchActivity extends Activity
{
    /** @var OrderService */
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

        return 1 === preg_match('/^#[0-9]+$/', $update->getMessage()->getText());
    }


    /**
     * @param Update $update
     * @return int
     */
    public function handle(Update $update): int
    {
        preg_match('/^#([0-9]+)$/', $update->getMessage()->getText(), $arr);
        $id = (int)$arr[1];

        $texts = $this->orderService->getOrderInformation($id);

        foreach ($texts as $text) {
            /** @var string $text */
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'text' => $text,
                'parse_mode' => 'HTML',
                'chat_id' => ChatKeeper::instance()->getChat()->chat_id,
            ]);
        }

        return Activity::SUCCESS;
    }
}