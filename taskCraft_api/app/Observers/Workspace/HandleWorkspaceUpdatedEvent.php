<?php

namespace App\Observers\Workspace;

use App\Events\WorkspaceUpdated;
use App\Models\BoardList;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HandleWorkspaceUpdatedEvent
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function handle(): void
    {
        if ($this->model->isDirty()) {
            $noNeededAttr = ['updated_at'];

            $changes = $this->model->getChanges();
            foreach($changes as $key=>$change) {
                if (!in_array($key, $noNeededAttr)) {
                    activity()
                        ->causedBy(Auth::user())
                        ->performedOn($this->model)
                        ->withProperties([
                            'new' => [$key => $change],
                            'old' => [$key => $this->model->getOriginal()[$key]],
                            'logMessage' => $this->handleMessage($key, $this->model->getOriginal()[$key], $change )
                        ])
                        ->log('Workspace Updated');
                }
            }

            broadcast(new WorkspaceUpdated($this->model))->toOthers();
        }
    }


    private function handleMessage($key, $original, $new): string
    {
        switch($key) {
            case('start_date'):
            case('due_date'):
                $dateKey = ucwords(str_replace('_', ' ', $key));
                $formattedOriginal = Carbon::parse($original)->format('m/d/Y');
                $formattedNew = Carbon::parse($new)->format('m/d/Y');
                return "$dateKey changed from {$formattedOriginal} to $formattedNew";
            case('priority'):
                return "Priority changed from $original to $new";
            case('list_id'):
                $originalList = BoardList::query()->find($original);
                $newList = BoardList::query()->find($new);

                return "Task moved from {$originalList->title} list to {$newList->title} list";
            default:
                return "$key changed from $original to $new";
        }
    }

}
