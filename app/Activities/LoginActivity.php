<?php

namespace App\Activities;

use Telegram\Bot\Objects\Update;

class LoginActivity extends Activity
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
    public function handle(Update $update): bool
    {
        // TODO: Implement handle() method.
    }
}
