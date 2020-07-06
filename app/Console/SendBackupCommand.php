<?php

namespace App\Console;

use App\Chat;
use App\Events\EventList;
use App\Helpers\EventListeners;
use App\Listener;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendBackupCommand extends Command
{
    /** @var string $signature */
    protected $signature = 'telegram:backup:send {fileName}';

    /** @var string $description */
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
            /** @var Chat $chat */
            Telegram::sendDocument([
                'chat_id' => $chat->chat_id,
                'caption' => 'Backup',
                'document' => $path,
            ]);
        }
    }
}
