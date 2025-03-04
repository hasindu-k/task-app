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
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                        <input type="datetime-local" id="time" name="time"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
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
        function openTaskModal() {
            document.getElementById('taskModal').classList.remove('hidden');
        }

        function closeTaskModal() {
            document.getElementById('taskModal').classList.add('hidden');
        }

        function viewTask(id, title, description, status, time) {
            document.getElementById('viewTaskTitle').innerText = title;
            document.getElementById('viewTaskDescription').innerText = description;
            document.getElementById('viewTaskTime').innerText = `Due: ${time}`;
            let statusLabel = document.getElementById('viewTaskStatus');
            statusLabel.innerText = status;
            statusLabel.className = status === 'Completed' ? 'bg-green-500 text-white px-2 py-1 text-xs font-medium' :
                status === 'In Progress' ? 'bg-yellow-500 text-white px-2 py-1 text-xs font-medium' :
                'bg-red-500 text-white px-2 py-1 text-xs font-medium';
            document.getElementById('viewTaskModal').classList.remove('hidden');
        }

        function closeViewTaskModal() {
            document.getElementById('viewTaskModal').classList.add('hidden');
        }
    </script>
@endsection
