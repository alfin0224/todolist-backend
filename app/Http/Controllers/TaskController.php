<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::cursor();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }

    public function sendManualReminderEmail($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Logic to send reminder email
        // Mail::to($task->email)->send(new ReminderEmail($task));

        Mail::to($task->email)->send(new ReminderEmail($task));

        $task->update([
            'reminder_status' => true,
            'reminder_date' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Reminder email sent']);
    }


    public function sendReminderAutoEmails()
{
    $now = Carbon::now();
    $reminderDate = $now->addDays(1);

    $tasks = Task::where('due_date', '<', $reminderDate)->where('completed', false)->get();

    foreach ($tasks as $task) {
        Mail::to('alfinmuhamad0224@gmail.com')->send(new ReminderEmail($task));
        
        $task->update([
            'reminder_status' => true,
            'reminder_date' => Carbon::now(),
        ]);
    }

    return response()->json(['message' => 'Reminder emails sent.']);
}


    public function summary()
    {
        $totalTasks =  Task::count();
        $completedTasks = Task::where('completed', true)->count();
        $pendingTasks = Task::where('completed', false)->count();

        $tomorrowDate = Carbon::now()->addDay()->endOfDay();
        $upcomingDeadline = Task::where('completed', false)
        ->where('due_date', '<=', $tomorrowDate)
        ->count();

        return response()->json([
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'upcoming_deadline' => $upcomingDeadline,
        ]);
    }

    public function completedTasks()
    {
        $completedTasks = Task::where('completed', true)->get();
        return response()->json($completedTasks);
    }

    public function upcomingDeadlines()
    {
        $tomorrowDate = Carbon::now()->addDay()->endOfDay();
        $upcomingDeadlines = Task::where('completed', false)
        ->where('due_date', '<=', $tomorrowDate)
        ->get();

        return response()->json($upcomingDeadlines);
    }
}
