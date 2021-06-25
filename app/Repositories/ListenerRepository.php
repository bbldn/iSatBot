<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Listener;

class ListenerRepository
{
    /**
     * @param User $user
     * @param string $event
     * @return Listener|null
     */
    public function findOneByUserAndEvent(User $user, string $event): ?Listener
    {
        /** @var Listener|null $listener */
        $listener = Listener::where(Listener::userId, $user->id)
            ->where(Listener::event, $event)
            ->first();

        return $listener;
    }
}