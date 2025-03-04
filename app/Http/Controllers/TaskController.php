<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = Task::where('user_id', Auth::id())->paginate(10);
            return TaskResource::collection($tasks);
        } catch (Exception $e) {
            Log::error("Tasks retrieval failed", ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Tasks retrieval failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $validatedTask = $request->validated();
            if ($request->hasFile('attachment')) {
                $filePath = $request->file('attachment')->store('attachment', config('filesystems.storage_disk'));
                $validatedTask['attachment'] = $filePath;
            }
            $validatedTask['user_id'] = Auth::id();

            $task = Task::create($validatedTask);

            return response()->json([
                'message' => 'Task created successfully',
                'task' => new TaskResource($task)
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error("Task creation failed", ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Task creation failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            Gate::authorize('view', $task);

            return response()->json([
                'task' => new TaskResource($task)
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Task retrieval failed", ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Task retrieval failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            Gate::authorize('update', $task);
            $validatedTask = $request->validated();

            if ($request->hasFile('attachment')) {
                $filePath = $request->file('attachment')->store('attachment', config('filesystems.storage_disk'));
                $validatedTask['attachment'] = $filePath;
            }

            $task->update($request->validated());

            return response()->json([
                'message' => 'Task updated successfully',
                'task' => new TaskResource($task)
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Task update failed", ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Task update failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            Gate::authorize('delete', $task);
            $task->delete();

            return response()->json([
                'message' => 'Task deleted successfully'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Task deletion failed", ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Task deletion failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
