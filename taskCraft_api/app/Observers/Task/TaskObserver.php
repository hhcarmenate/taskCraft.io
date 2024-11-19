<?php

namespace App\Observers\Task;

use App\Observers\Observer;
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
        if ($model->isDirty()) {
            $noNeededAttr = ['updated_at'];

            $changes = $model->getChanges();
            foreach($changes as $key=>$change) {
                if (!in_array($key, $noNeededAttr)) {
                    activity()
                        ->causedBy(Auth::user())
                        ->performedOn($model)
                        ->withProperties(['new' => [$key => $change], 'old' => [$key => $model->getOriginal()[$key]] ])
                        ->log('Task Created');
                }
            }

        }
    }

    public function deleting($model)
    {
        // TODO: Implement deleting() method.
    }

    public function deleted($model)
    {
        // TODO: Implement deleted() method.
    }
}
