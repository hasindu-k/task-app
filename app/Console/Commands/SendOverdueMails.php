<?php

namespace App\Console\Commands;

use App\Mail\OverdueMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendOverdueMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:overdue-mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send overdue task reminder emails to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch overdue tasks from the database
        $overdueTasks = \App\Models\Task::where('time', '<', now())
            ->where('status', '!=', 'Completed')
            ->get();

        if ($overdueTasks->isEmpty()) {
            $this->info('No overdue tasks found.');
            return;
        }

        // Group tasks by user
        $tasksByUser = $overdueTasks->groupBy('user_id');

        foreach ($tasksByUser as $userId => $tasks) {
            $user = \App\Models\User::find($userId);

            if ($user) {
                Mail::to($user->email)->send(new OverdueMail($user->name, $tasks));
            }
        }

        $this->info('Overdue task reminder emails sent successfully.');
    }
}
