<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Mail\OverdueMail;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = Task::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
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
                if (!empty($task->attachment) && Storage::disk(config('filesystems.storage_disk'))->exists($task->attachment)) {
                    Storage::disk(config('filesystems.storage_disk'))->delete($task->attachment);
                }
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
        } catch (AuthorizationException $e) {
            Log::warning("Unauthorized task deletion attempt", [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'task_id' => $task->id
            ]);

            return response()->json([
                'message' => 'You are not authorized to delete this task.'
            ], Response::HTTP_FORBIDDEN);
        } catch (ModelNotFoundException $e) {
            Log::error("Task not found", [
                'error' => $e->getMessage(),
                'task_id' => $task->id
            ]);

            return response()->json([
                'message' => 'Task not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (QueryException $e) {
            Log::error("Database error during task deletion", [
                'error' => $e->getMessage(),
                'task_id' => $task->id
            ]);

            return response()->json([
                'message' => 'Database error occurred while deleting the task.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (NotFoundHttpException $e) {
            Log::error("Task deletion failed - Task does not exist", [
                'error' => $e->getMessage(),
                'task_id' => $task->id
            ]);

            return response()->json([
                'message' => 'Task not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::error("Task deletion failed", ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Task deletion failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function download(Request $request)
    {
        try {
            $filePath = urldecode($path);
            $relativePath = str_replace(url('/storage/'), '', $filePath);

            if (!Storage::exists("attachment/" . $relativePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            return response()->download(storage_path("app/public/attachment/" . $relativePath));
        } catch (Exception $e) {
            Log::error("File download failed", ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'File download failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendOverDueMails()
    {
        try {
            $user = Auth::user();

            $tasks = Task::where('time', '<', now())->where('user_id', $user->id)->get();

            if ($tasks->isEmpty()) {
                return;
            }

            Mail::to($user->email)->send(new OverdueMail($user->name, $tasks));
        } catch (Exception $e) {
            Log::error("Mail send failed", ['error' => $e->getMessage()]);
        }
    }

    public function getCompletedTaskByEach()
    {
        return User::with('tasks')->where('status', 'Completed')->count();
    }
}
