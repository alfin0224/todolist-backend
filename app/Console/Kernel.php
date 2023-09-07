<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use App\Jobs\ReminderEmailJob;
use Carbon\Carbon;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('send:reminder-emails')->everyFiveMinutes();

        $now = now();
        $dueDateLimit = $now->copy()->addDay(); 
    
        $tasks = Task::where('due_date', '<=', $dueDateLimit)->get();
    
        foreach ($tasks as $task) {
            $schedule->job(new ReminderEmailJob($task))->everyFiveMinutes();

            $task->update([
                'reminder_status' => true,
                'reminder_date' => Carbon::now(),
            ]);
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
