<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container mx-auto max-w-3xl bg-white p-6 rounded-lg shadow-lg py-12 mt-4">
        <h2 class="flex-grow text-center text-2xl mb-4 font-bold">Task Management System</h2>

        <button onclick="openTaskModal()"
            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add
            New Task</button>

        <ul id="task-titles-list" class="space-y-3 mt-4">
        </ul>

        <div id="pagination" class="flex justify-center space-x-2 mt-4"></div>

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
                        <input type="file" id="attachment" name="attachment"
                            accept="image/jpeg, image/png, image/jpg"
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

        <div id="editTaskModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-bold mb-4">Edit Task</h2>
                <form id="edit-task-form" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" id="edit-taskId" name="taskId">
                    <div class="text-red-500" id="editErrorMessage"></div>
                    <div>
                        <label for="edit-title" class="block text-sm font-medium text-gray-700">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit-title" name="title"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                        <div class="text-red-500 invalid-feedback error-messages error_title"></div>
                    </div>
                    <div>
                        <label for="edit-time" class="block text-sm font-medium text-gray-700">Due Date <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" id="edit-time" name="time"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                        <div class="text-red-500 invalid-feedback error-messages error_time"></div>
                    </div>
                    <div>
                        <label for="edit-description"
                            class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="edit-description" name="description" rows="3"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
                        <div class="text-red-500 invalid-feedback error-messages error_description"></div>
                    </div>
                    <div>
                        <label for="edit-status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="edit-status" name="status"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <div class="text-red-500 invalid-feedback error-messages error_status"></div>
                    </div>
                    <div>
                        <label for="edit-attachment" class="block text-sm font-medium text-gray-700">Attachment (JPEG,
                            PNG,
                            JPG)</label>
                        <input type="file" id="edit-attachment" name="attachment"
                            accept="image/jpeg, image/png, image/jpg"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                        <img id="edit-attachment-preview" src="" alt="Attachment Preview"
                            class="hidden w-32 h-32 object-cover mt-2" />
                        <div class="text-red-500 invalid-feedback error-messages error_attachment"></div>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Update
                        Task</button>
                </form>
                <button onclick="closeEditTaskModal()"
                    class="mt-4 w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Close</button>
            </div>
        </div>

        <div id="viewTaskModal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="viewTaskTitle" class="text-2xl font-semibold text-gray-800 "></h2>
                    <p id="viewTaskTime" class="text-sm text-gray-500"></p>
                </div>
                <p id="viewTaskDescription" class="text-gray-700 mt-3"></p>
                <span id="viewTaskStatus" class="px-3 py-1 text-sm font-medium "></span>
                <img id="viewTaskAttachment" src="" alt="Attachment Preview"
                    class="hidden w-32 h-32 object-cover mt-2" />
                <button onclick="closeViewTaskModal()"
                    class="mt-4 w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Close</button>
            </div>
        </div>

        <div id="userMenuModal"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm relative">

                <button onclick="closeUserMenuModal()"
                    class="absolute top-3 right-3 bg-red-400 text-white p-2 rounded-full hover:bg-red-500 transition">
                    ✖
                </button>

                <h2 class="text-lg font-semibold text-gray-800 mb-4 text-center">User Menu</h2>
                <a href="{{ route('profile.edit') }}"
                    class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 transition mb-2">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-400 text-white py-2 px-4 rounded-md hover:bg-red-500 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
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
                        closeTaskModal();
                        Swal.fire({
                            title: "Created!",
                            text: "The task has been created.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            loadTasks();
                        });
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

        function loadTasks(page = 1) {
            $.ajax({
                url: `/api/tasks?page=${page}`,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    let tasks = response.data;
                    let taskList = $("#task-titles-list");
                    let paginationContainer = $("#pagination");

                    taskList.empty();
                    paginationContainer.empty();

                    if (tasks.length === 0) {
                        taskList.append('<li class="text-gray-500 text-center">No tasks found</li>');
                        return;
                    }

                    tasks.forEach((task) => {
                        taskList.append(`
                    <li class="flex items-center bg-gray-100 p-3 rounded-md shadow-sm">
                        <span class="text-lg flex-grow font-semibold text-gray-800 cursor-pointer"
                            onclick="viewTask('${task.id}')">
                            ${task.title}
                        </span>
                        <span class="ml-2">
                            <i class="fas fa-edit text-blue-500 cursor-pointer hover:text-blue-700"
                            onclick="openEditTaskModal('${task.id}')"></i>
                            <i class="fas fa-trash-alt text-red-500 cursor-pointer hover:text-red-700 ml-2"
                            onclick="deleteTask('${task.id}')"></i>
                        </span>
                    </li>
                `);
                    });

                    renderPagination(response.meta);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching tasks:", error);
                }
            });
        }

        function renderPagination(meta) {
            let paginationContainer = $("#pagination");

            if (meta.last_page > 1) {
                if (meta.current_page > 1) {
                    paginationContainer.append(
                        `<button onclick="loadTasks(${meta.current_page - 1})"
                class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-1">
                    Prev
                </button>`
                    );
                }

                for (let i = 1; i <= meta.last_page; i++) {
                    paginationContainer.append(
                        `<button onclick="loadTasks(${i})"
                class="px-3 py-1 ${meta.current_page === i ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-800'}
                rounded-md hover:bg-gray-400 mx-1">
                    ${i}
                </button>`
                    );
                }

                if (meta.current_page < meta.last_page) {
                    paginationContainer.append(
                        `<button onclick="loadTasks(${meta.current_page + 1})"
                class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 ml-1">
                    Next
                </button>`
                    );
                }
            }
        }

        function openTaskModal() {
            $('#taskModal').removeClass('hidden');
        }

        function closeTaskModal() {
            $('#taskModal').addClass('hidden');
        }

        function openUserMenuModal() {
            $('#userMenuModal').removeClass('hidden');
        }

        function closeUserMenuModal() {
            $('#userMenuModal').addClass('hidden');
        }

        function getTask(taskId, callback) {
            $.ajax({
                url: `/api/tasks/${taskId}`,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (callback) callback(response.task);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching task:", error);
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to fetch task details. Please try again later.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        }

        function viewTask(taskId) {
            getTask(taskId, function(task) {
                $('#viewTaskTitle').text(task.title);
                $('#viewTaskDescription').text(task.description);

                const taskTime = moment(task.time);
                const now = moment();
                const diff = taskTime.diff(now, 'days');

                $('#viewTaskTime').text(diff > 0 ? `${diff} days left` : diff === 0 ? "Due today" :
                    `Overdue by ${Math.abs(diff)} days`);

                let statusLabel = $('#viewTaskStatus');
                statusLabel.text(task.status);
                statusLabel.removeClass().addClass(
                    `px-2 py-1 text-xs font-medium rounded-sm ${
                task.status === 'Completed' ? 'bg-green-500 text-white' :
                task.status === 'In Progress' ? 'bg-yellow-500 text-white' :
                'bg-red-500 text-white'
            }`
                );

                if (task.attachment) {
                    let filePreview = $('#viewTaskAttachment');
                    filePreview.attr('src', `${task.attachment}`).removeClass('hidden');
                }

                $('#viewTaskModal').removeClass('hidden');
            });
        }

        function openEditTaskModal(taskId) {
            getTask(taskId, function(task) {
                $('#edit-taskId').val(task.id);
                $('#edit-title').val(task.title);
                $('#edit-time').val(task.time);
                $('#edit-description').val(task.description);
                $('#edit-status').val(task.status);

                if (task.attachment) {
                    let filePreview = $('#edit-attachment-preview');
                    filePreview.attr('src', `${task.attachment}`).removeClass('hidden');
                }

                $('#editTaskModal').removeClass('hidden');
            });
        }

        function closeEditTaskModal() {
            $('#editTaskModal').addClass('hidden');
        }

        function closeViewTaskModal() {
            $('#viewTaskModal').addClass('hidden');
        }

        function deleteTask(taskId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to recover this task!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/api/tasks/${taskId}`,
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function() {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The task has been deleted.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                loadTasks();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error deleting task:", error);
                            try {
                                const response = JSON.parse(xhr.responseText);
                                var message = response.message;
                            } catch (e) {
                                var message = ('An unexpected error occurred.');
                            }
                            Swal.fire({
                                title: "Error!",
                                text: message,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
            });
        }

        $('#edit-task-form').submit(function(event) {
            event.preventDefault();

            let taskId = $('#edit-taskId').val();
            let formData = new FormData(this);

            formData.append('_method', 'PUT');

            $.ajax({
                url: `/api/tasks/${taskId}`,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: "Updated!",
                        text: "Task updated successfully.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        closeEditTaskModal();
                        loadTasks();
                    });
                },
                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $('.error-messages').hide();
                        for (let field in errors) {
                            errorMessages = `<p>${errors[field].join(', ')}</p>`;
                            $('.error_' + field).html(errorMessages).show();
                        }
                    } else {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            var message = response.message;
                        } catch (e) {
                            var message = ('An unexpected error occurred.');
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    </script>
</x-app-layout>
