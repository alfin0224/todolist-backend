<?php

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;

class SendReminderEmails extends Command
{
    protected $signature = 'send:reminder-emails';

    protected $description = 'Send reminder emails for tasks with due_date less than 1 day from deadline';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $dueDateLimit = $now->copy()->addDay(); 

        $tasks = Task::where('due_date', '<=', $dueDateLimit)
            ->where('completed', false)
            ->get();

        foreach ($tasks as $task) {
            Mail::to($task->email)->send(new ReminderEmail($task));

            $task->update([
                'reminder_status' => true,
                'reminder_date' => Carbon::now(),
            ]);
        }

        $this->info('Reminder emails sent successfully.');
    }
}

