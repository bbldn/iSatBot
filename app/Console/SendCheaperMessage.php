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
    /** @var string */
    protected $signature = 'telegram:cheaper:send {message}';

    /** @var string */
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

        $result = $this->convert($data);
        $data = [
            'data' => $result,
            'filter' => function ($value) {
                return '+' . str_replace([' ', '(', ')', '-',], '', $value);
            },
            'tester' => function ($value) {
                return 1 === preg_match('/^38 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/', $value);
            },
        ];

        $event = $this->getEventCode($result['Комментарий']);
        $chats = EventListeners::getChatsByEvent($event);
        foreach ($chats as $chat) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => view('cheaper', $data)->toHtml(),
                'parse_mode' => 'HTML',
            ]);
        }
    }

    /**
     * @param string $comment
     * @return string
     */
    protected function getEventCode(string $comment): string
    {
        $comment = mb_strtolower(trim($comment));
        if ('test' === $comment || 'тест' === $comment) {
            return EventList::TEST;
        }

        return EventList::ORDER_NEW;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function convert(array $data): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[$value['name']] = $value['value'];
        }

        return $result;
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
