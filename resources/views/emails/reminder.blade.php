<!DOCTYPE html>
<html>
<head>
    <title>Task Reminder</title>
</head>
<body>
    <p>Dear User,</p>
    <p>This is a reminder that your task:</p>
    <p>Title: {{ $task->title }}</p>
    <p>Description: {{ $task->description }}</p>
    <p>Due Date: {{ $task->due_date }}</p>
    <p>is due soon. Please complete it.</p>
    <p>Regards,</p>
    <p>Todo List App Ivosights Team</p>
</body>
</html>
