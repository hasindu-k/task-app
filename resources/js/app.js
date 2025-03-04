import "./bootstrap";

import Alpine from "alpinejs";
import $ from "jquery";

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function () {
    function loadTasks() {
        $.get("/api/tasks", function (response) {
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
                    <li class="flex justify-between items-center bg-gray-100 p-3 rounded-md shadow-sm">
                        <span class="text-lg font-semibold text-gray-800 cursor-pointer"
                              onclick="viewTask('${task.id}', '${task.title}', '${task.description}', '${task.status}', '${task.time}')">
                            ${task.title}
                        </span>
                    </li>
                `);
                });
            }
        });
    }

    loadTasks();

    $("#task-form").submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "/api/tasks",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                $("#task-form")[0].reset();
                loadTasks();
            },
        });
    });
});
