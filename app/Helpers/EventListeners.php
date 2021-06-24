<?php

namespace App\Helpers;

use App\Chat;
use App\Listener;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EventListeners
{
    /**
     * @param string $event
     * @return Collection|Chat[]
     */
    public static function getChatsByEvent(string $event): Collection
    {
        $chat = new Chat();
        $listener = new Listener();

        return DB::table($chat->getTable())
            ->leftJoin(
                $listener->getTable(),
                "{$chat->getTable()}.user_id",
                '=',
                "{$listener->getTable()}.user_id"
            )
            ->where('event', $event)
            ->get();
    }
}