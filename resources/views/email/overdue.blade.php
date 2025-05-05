<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Overdue Tasks</title>
</head>

<body>
    <h1>Hello {{ $name }},</h1>

    <p>You have the following overdue tasks:</p>

    <ul>
        @foreach ($tasks as $task)
            <li>{{ $task->title }} - Due: {{ $task->time->format('Y-m-d H:i') }}</li>
        @endforeach
    </ul>

    <p>Please take necessary actions as soon as possible.</p>

    <p>Regards,<br>Your Task Manager</p>
</body>

</html>
