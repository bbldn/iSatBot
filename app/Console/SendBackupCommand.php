<?php

namespace App\Console;

use App\Chat;
use App\Events\EventList;
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

        $chat = new Chat();
        $listener = new Listener();

        $chats = DB::table($chat->getTable())
            ->leftJoin(
                $listener->getTable(),
                "{$chat->getTable()}.user_id",
                '=',
                "{$listener->getTable()}.user_id"
            )
            ->where('event', $event)
            ->get();

        foreach ($chats as $chat) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendDocument([
                'chat_id' => $chat->chat_id,
                'caption' => 'Backup',
                'document' => $path,
            ]);
        }
    }
}
