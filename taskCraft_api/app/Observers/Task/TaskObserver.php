<?php

namespace App\Observers\Task;

use App\Observers\Observer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskObserver extends Observer
{

    public function creating($model)
    {
        // TODO: Implement creating() method.
    }

    /**
     * Logs an activity for the creation of a task.
     *
     * @param mixed $model The task model to perform the activity on.
     * @return void
     */
    public function created($model): void
    {
        activity()
            ->causedBy(Auth::user())
            ->performedOn($model)
            ->withProperties($model->toArray())
            ->log('Task Created');
    }

    public function updating($model)
    {
        // TODO: Implement updating() method.
    }

    public function updated($model): void
    {
        Log::info('Triggered update', [$model]);
        try {
            (new HandleUpdatedEvent($model))->handle();
        } catch (Exception $e) {
            Log::info('Observer Error', [$e->getMessage()]);
        }
    }

    public function deleting($model)
    {
        // TODO: Implement deleting() method.
    }

    public function deleted($model): void
    {
        activity()
            ->causedBy(Auth::user())
            ->performedOn($model)
            ->withProperties($model->toArray())
            ->log('Task Deleted');
    }
}
