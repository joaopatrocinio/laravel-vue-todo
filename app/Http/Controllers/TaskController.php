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
     * @OA\Get(
     *      path="/api/tasks",
     *      summary="Get all tasks",
     *      tags={"Tasks"},
     *      @OA\Response(response="200", description="List complete.")
     * )
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
     * @OA\Post(
     *      path="/api/tasks",
     *      summary="Add a new task",
     *      tags={"Tasks"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="status_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(response="200", description="Create complete.")
     * )
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
     * @OA\Get(
     *      path="/api/tasks/{id}",
     *      summary="Get a specific task",
     *      tags={"Tasks"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Task ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *             type="integer"
     *          )                
     *      ),
     *      @OA\Response(response="200", description="List complete.")
     * )
     */
    public function show(string $id): JsonResponse
    {
        $task = Task::find($id);

        if (empty($task)) {
            return response()->json([
                'message' => 'Task not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'List complete.',
            'payload' => new TaskResource($task)
        ]);
    }

    /**
     * @OA\Put(
     *      path="/api/tasks/{id}",
     *      summary="Update a task",
     *      tags={"Tasks"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Task ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *             type="integer"
     *          )                
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="status_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(response="200", description="Update complete.")
     * )
     */
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();
        $updatedTask = Task::find($id);

        if (empty($updatedTask)) {
            return response()->json([
                'message' => 'Task not found.'
            ], 404);
        }

        $updatedTask->fill($validated);

        if (!$updatedTask->save()) {
            return response()->json([
                'message' => 'Nothing was updated.'
            ], 422);
        }
        
        return response()->json([
            'message' => 'Update complete.',
            'payload' => new TaskResource($updatedTask)
        ]);

    }

    /**
     * @OA\Delete(
     *      path="/api/tasks/{id}",
     *      summary="Delete a specific task",
     *      tags={"Tasks"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Task ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *             type="integer"
     *          )                
     *      ),
     *      @OA\Response(response="200", description="Delete complete.")
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        if (Task::destroy($id) <= 0) {
            return response()->json([
                'message' => 'Nothing was deleted.'
            ], 422);
        }
        
        return response()->json([
            'message' => 'Delete complete.'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/tasks/markAsCompleted",
     *      summary="Mark a task as completed",
     *      tags={"Tasks"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(response="200", description="Update complete.")
     * )
     */
    public function markAsCompleted(Request $request): JsonResponse
    {
        $validated = $request->only(["id"]);
        $updatedTask = Task::find($validated["id"]);

        if (empty($updatedTask)) {
            return response()->json([
                'message' => 'Task not found.'
            ], 404);
        }

        $updatedTask->status_id = StatusEnum::COMPLETED->value;

        if (!$updatedTask->save()) {
            return response()->json([
                'message' => 'Nothing was updated.'
            ], 422);
        }
        
        return response()->json([
            'message' => 'Update complete.',
            'payload' => new TaskResource($updatedTask)
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/tasks/markAsPending",
     *      summary="Mark a task as pending",
     *      tags={"Tasks"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(response="200", description="Update complete.")
     * )
     */
    public function markAsPending(Request $request): JsonResponse
    {
        $validated = $request->only(["id"]);
        $updatedTask = Task::find($validated["id"]);

        if (empty($updatedTask)) {
            return response()->json([
                'message' => 'Task not found.'
            ], 404);
        }

        $updatedTask->status_id = StatusEnum::PENDING->value;

        if (!$updatedTask->save()) {
            return response()->json([
                'message' => 'Nothing was updated.'
            ], 422);
        }
        
        return response()->json([
            'message' => 'Update complete.',
            'payload' => new TaskResource($updatedTask)
        ]);
    }
}
