<?php

use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');
Schedule::command('inspire')->everyFiveMinutes();

// while true; do php artisan schedule:run; sleep 60; done
