<?php

namespace App\Activities;

use Telegram\Bot\Objects\Update;

abstract class Activity
{
    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        return false;
    }

    /**
     * @param Update $update
     * @return bool
     */
    public abstract function handle(Update $update): bool;
}
