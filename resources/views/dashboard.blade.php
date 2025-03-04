@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto max-w-3xl bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-bold mb-4">Task Management System</h2>

        <button onclick="openTaskModal()"
            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add
            New Task</button>

        <ul id="task-titles-list" class="space-y-3 mt-4">
        </ul>

        <div id="taskModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-bold mb-4">Add New Task</h2>
                <form id="task-form" method="POST" class="space-y-4">
                    @csrf
                    <div class="text-red-500" role="alert" id="errorMessage">
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title
                            <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="text-red-500 invalid-feedback error-messages error_title"></div>
                    </div>
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700">Due Date
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="time" name="time"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="text-red-500 invalid-feedback error-messages error_time"></div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description
                        </label>
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        <div class="text-red-500 invalid-feedback error-messages error_description"></div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <div class="text-red-500 invalid-feedback error-messages error_status"></div>
                    </div>
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment (JPEG, PNG,
                            JPG)</label>
                        <input type="file" id="attachment" name="attachment" accept="image/jpeg, image/png, image/jpg"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="text-red-500 invalid-feedback error-messages error_attachment"></div>
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Submit
                        Task</button>
                </form>
                <button onclick="closeTaskModal()"
                    class="mt-4 w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Close</button>
            </div>
        </div>

        <div id="viewTaskModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 id="viewTaskTitle" class="text-xl font-bold mb-4"></h2>
                <p id="viewTaskDescription" class="text-gray-700 mb-2"></p>
                <p id="viewTaskTime" class="text-sm text-gray-500"></p>
                <span id="viewTaskStatus" class="px-2 py-1 text-xs font-medium"></span>
                <button onclick="closeViewTaskModal()"
                    class="mt-4 w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Close</button>
            </div>
        </div>


        {{-- <form id="task-form" method="POST" class="mb-4 space-y-4">
            @csrf
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div>
                <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment (JPEG, PNG, JPG)</label>
                <input type="file" id="attachment" name="attachment" accept="image/jpeg, image/png, image/jpg"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                <input type="datetime-local" id="time" name="time"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Submit
                Task</button>
        </form> --}}

        {{-- <ul id="task-list" class="space-y-3 mt-4">
            @forelse ($tasks as $task)
            <li class="flex justify-between items-center bg-gray-100 p-3 rounded-md shadow-sm">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                    <span class="text-xs text-gray-500">Due: {{ $task->time }}</span>
                    <span
                        class="ml-2 px-2 py-1 text-xs font-medium
                    {{ $task->status == 'Completed' ? 'bg-green-500 text-white' : ($task->status == 'In Progress' ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                        {{ $task->status }}
                    </span>
                </div>
                <div class="space-x-2">
                    <!-- Edit Button -->
                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                    </form>
                </div>
            </li>
            @empty
            @endforelse
        </ul> --}}

    </div>

    <script>
        $(document).ready(function() {
            function loadTasks() {
                $.get("/api/tasks", function(response) {
                    let tasks = response.data;
                    let taskList = $("#task-titles-list");
                    taskList.empty();

                    if (tasks.length === 0) {
                        taskList.append(
                            '<li class="text-gray-500 text-center">No tasks found</li>'
                        );
                    } else {
                        tasks.forEach((task) => {
                            taskList.append(`
                    <li class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm">
                        <span class="text-lg flex-grow font-semibold text-gray-800 cursor-pointer"
                            onclick="viewTask('${task.id}', '${task.title}', '${task.description}', '${task.status}', '${task.time}')">
                            ${task.title}
                        </span>
                        <span class="ml-2">
                            <i class="fas fa-edit text-blue-500 cursor-pointer hover:text-blue-700"
                            onclick="editTask('${task.id}')"></i>
                            <i class="fas fa-trash-alt text-red-500 cursor-pointer hover:text-red-700 ml-2"
                            onclick="deleteTask('${task.id}')"></i>
                        </span>
                    </li>
                `);
                        });
                    }
                });
            }

            loadTasks();

            $("#task-form").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "/api/tasks",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        $("#task-form")[0].reset();
                        loadTasks();
                        closeTaskModal();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            $('.error-messages').hide();

                            for (let field in errors) {
                                errorMessages = `<p>${errors[field].join(', ')}</p>`;
                                $('.error_' + field).html(errorMessages).show();
                            }

                        } else {
                            let response = JSON.parse(xhr.responseText);
                            console.error("Error:", response.message);

                            $('#errorMessage').text(response.message).removeClass('d-none')
                                .fadeIn();

                            setTimeout(function() {
                                $('#errorMessage').fadeOut();
                            }, 5000);
                        }
                    }
                });
            });
        });

        function openTaskModal() {
            $('#taskModal').removeClass('hidden');
        }

        function closeTaskModal() {
            $('#taskModal').addClass('hidden');
        }

        function viewTask(id, title, description, status, time) {
            $('#viewTaskTitle').text(title);
            $('#viewTaskDescription').text(description);
            $('#viewTaskTime').text(`Due: ${time}`);

            let statusLabel = $('#viewTaskStatus');
            statusLabel.text(status);
            statusLabel.removeClass().addClass(
                status === 'Completed' ? 'bg-green-500 text-white px-2 py-1 text-xs font-medium' :
                status === 'In Progress' ? 'bg-yellow-500 text-white px-2 py-1 text-xs font-medium' :
                'bg-red-500 text-white px-2 py-1 text-xs font-medium'
            );

            $('#viewTaskModal').removeClass('hidden');
        }

        function closeViewTaskModal() {
            $('#viewTaskModal').addClass('hidden');
        }

        function deleteTask(taskId) {
            fetch(`/api/tasks/${taskId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    "Content-Type": "application/json",
                },
            }).then((response) => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }

        function editTask(taskId) {
            fetch(`/api/tasks/${taskId}`, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json",
                },
            }).then((response) => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    </script>
@endsection
