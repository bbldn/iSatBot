<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        Broadcast::routes();

        /** @noinspection PhpIncludeInspection */
        require base_path('routes/channels.php');
    }
}
