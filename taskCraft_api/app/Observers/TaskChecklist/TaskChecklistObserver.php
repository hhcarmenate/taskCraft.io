<?php

namespace App\Observers\TaskChecklist;

use App\Events\BoardUpdated;
use App\Models\BoardList;
use App\Observers\Observer;
use Illuminate\Support\Facades\Auth;

class TaskChecklistObserver extends Observer
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
            ->log('Task Checklist Created');

        $task = $model->task;

        if ($task) {
            $list = BoardList::query()
                ->with('board')
                ->find($task->list_id);

            if ($list && $list->board) {
                broadcast(new BoardUpdated($list->board));
            }
        }
    }

    public function updating($model)
    {
        // TODO: Implement updating() method.
    }

    public function updated($model): void
    {
        // TODO: Implement update() method.
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
