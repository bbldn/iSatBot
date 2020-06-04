<?php

namespace App\Activities;

use Telegram\Bot\Objects\Update;

class SettingActivity extends Activity
{
    /**
     * @param Update $update
     * @return int
     */
    public function handle(Update $update): int
    {
        return Activity::FAIL;
    }
}
