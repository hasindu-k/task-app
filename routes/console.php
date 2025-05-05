<?php

use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');
Schedule::command('inspire')->everyFiveMinutes();

Schedule::command('send:overdue-mails')->dailyAt('00:30');

// while true; do php artisan schedule:run; sleep 60; done
// php artisan schedule:worke
