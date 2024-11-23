<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

class TaskLogsController extends Controller
{
    /**
     * Retrieves logs related to a specific task.
     *
     * @param Task $task The task for which logs will be retrieved.
     *
     * @return JsonResponse Returns a JSON response containing the logs of the specified task, in the format of id, log, and created_at fields.
     */
    public function getLogs(Task $task): JsonResponse
    {
        $activities = Activity::query()
            ->where('subject_type', 'App\Models\Task')
            ->where('subject_id', $task->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        if ($activities) {
            $formattedActivities = $activities->map(function($act) {
               return [
                   'id' => $act->id,
                   'action' => $act->description,
                   'details' => $act->properties['logMessage'] ?? '',
                   'user' => User::query()->find($act->causer_id),
                   'date' => Carbon::parse($act->created_at)->format('M. j, Y')
               ];
            });

            return response()->json($formattedActivities);
        }

        return response()->json([]);
    }
}
