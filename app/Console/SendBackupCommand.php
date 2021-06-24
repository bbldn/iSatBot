<?php

namespace App\Console;

use App\Events\EventList;
use App\Helpers\EventListeners;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendBackupCommand extends Command
{
    /** @var string */
    protected $signature = 'telegram:backup:send {fileName}';

    /** @var string */
    protected $description = 'Send Backups';

    /**
     *
     */
    public function handle(): void
    {
        $this->sendBackup(EventList::BACKUP, $this->argument('fileName'));
    }

    /**
     * @param string $event
     * @param string $path
     */
    protected function sendBackup(string $event, string $path): void
    {
        if (false === file_exists($path)) {
            return;
        }

        $chats = EventListeners::getChatsByEvent($event);
        foreach ($chats as $chat) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendDocument([
                'document' => $path,
                'caption' => 'Backup',
                'chat_id' => $chat->chat_id,
            ]);
        }
    }
}