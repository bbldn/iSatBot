<?php

namespace App\Console;

use App\Events\EventList;
use App\Helpers\EventListeners;
use App\Helpers\ExceptionFormatter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendCheaperMessage extends Command
{
    /** @var string $signature */
    protected $signature = 'telegram:cheaper:send {message}';

    /** @var string $description */
    protected $description = 'Send Cheaper Notification';

    /**
     *
     */
    public function handle(): void
    {
        $data = $this->parseDate($this->argument('message'));
        if (null === $data) {
            return;
        }

        $chats = EventListeners::getChatsByEvent(EventList::ORDER_NEW);
        foreach ($chats as $chat) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => view('cheaper', ['data' => $data])->toHtml(),
                'parse_mode' => 'HTML',
            ]);
        }
    }

    /**
     * @param string $message
     * @return array|null
     */
    protected function parseDate(string $message): ?array
    {
        $message = base64_decode($message);
        if (false === $message) {
            Log::info(ExceptionFormatter::f('Invalid data'));

            return null;
        }

        $data = json_decode($message, true);
        if (false === $data) {
            Log::info(ExceptionFormatter::f('Invalid data'));

            return null;
        }

        if (0 === count($data)) {
            Log::info(ExceptionFormatter::f('data is empty'));

            return null;
        }

        $data = $data[0];

        if (false === key_exists('info', $data)) {
            Log::info(ExceptionFormatter::f('`info` key not found'));

            return null;
        }

        $data = @unserialize($data['info']);

        if (false === $data) {
            Log::info(ExceptionFormatter::f('Error unserialize'));

            return null;
        }

        return $data;
    }
}
