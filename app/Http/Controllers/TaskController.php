<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();

        return response()->json([
            'message' => 'List complete.',
            'payload' => TaskResource::collection($tasks)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $newTask = Task::create($validated);

        return response()->json([
            'message' => 'Create complete.',
            'payload' => new TaskResource($newTask)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $task = Task::find($id);

        if (empty($task)) {
            return response()->json([
                'message' => 'Task not found.',
                'payload' => null
            ], 404);
        }

        return response()->json([
            'message' => 'List complete.',
            'payload' => new TaskResource($task)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();
        $updatedTask = Task::find($id);

        if (empty($updatedTask)) {
            return response()->json([
                'message' => 'Task not found.',
                'payload' => null
            ], 404);
        }

        $updatedTask->fill($validated);

        if (!$updatedTask->save()) {
            return response()->json([
                'message' => 'Nothing was updated.',
                'payload' => null
            ], 422);
        }
        
        return response()->json([
            'message' => 'Update complete.',
            'payload' => new TaskResource($updatedTask)
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if (Task::destroy($id) <= 0) {
            return response()->json([
                'message' => 'Nothing was deleted.',
                'payload' => null
            ], 422);
        }
        
        return response()->json([
            'message' => 'Delete complete.',
            'payload' => null
        ]);
    }

    public function markAsCompleted(Request $request): JsonResponse
    {
        $validated = $request->only(["id"]);
        $updatedTask = Task::find($validated["id"]);

        if (empty($updatedTask)) {
            return response()->json([
                'message' => 'Task not found.',
                'payload' => null
            ], 404);
        }

        $updatedTask->status_id = StatusEnum::COMPLETED->value;

        if (!$updatedTask->save()) {
            return response()->json([
                'message' => 'Nothing was updated.',
                'payload' => null
            ], 422);
        }
        
        return response()->json([
            'message' => 'Update complete.',
            'payload' => new TaskResource($updatedTask)
        ]);
    }

    public function markAsPending(Request $request): JsonResponse
    {
        $validated = $request->only(["id"]);
        $updatedTask = Task::find($validated["id"]);

        if (empty($updatedTask)) {
            return response()->json([
                'message' => 'Task not found.',
                'payload' => null
            ], 404);
        }

        $updatedTask->status_id = StatusEnum::PENDING->value;

        if (!$updatedTask->save()) {
            return response()->json([
                'message' => 'Nothing was updated.',
                'payload' => null
            ], 422);
        }
        
        return response()->json([
            'message' => 'Update complete.',
            'payload' => new TaskResource($updatedTask)
        ]);
    }
}
