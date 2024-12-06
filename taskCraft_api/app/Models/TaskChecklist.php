<?php

namespace App\Models;

use App\Observers\TaskChecklist\TaskChecklistObserver;
use App\Traits\RegisterObserverTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskChecklist extends Model
{
    use RegisterObserverTrait;

    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $table = 'task_checklists';

    protected $fillable = [
        'task_id',
        'title',
    ];

    public static function getObserverClass() : TaskChecklistObserver
    {
        return new TaskChecklistObserver();
    }


    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }


    public function checklistItem(): HasMany
    {
        return $this->hasMany(TaskChecklistItem::class, 'checklist_id', 'id');
    }

}
