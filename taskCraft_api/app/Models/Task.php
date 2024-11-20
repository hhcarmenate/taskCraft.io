<?php

namespace App\Models;

use App\Observers\Task\TaskObserver;
use App\Traits\RegisterObserverTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use RegisterObserverTrait;

    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'list_id',
        'title',
        'description',
        'priority',
        'created_by',
        'assigned_to',
        'start_date',
        'due_date',
        'position'
    ];

    public static function getObserverClass() : TaskObserver
    {
        return new TaskObserver();
    }

    /**
     * Board List relationship.
     * @return BelongsTo
     */
    public function boardList(): BelongsTo
    {
        return $this->belongsTo(BoardList::class, 'list_id', 'id');
    }

    /**
     * Get the user that created the instance.
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get the user that this item is assigned to.
     *
     * @return BelongsTo
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    /**
     * @return HasOne
     */
    public function taskChecklist(): HasOne
    {
        return $this->hasOne(TaskChecklist::class, 'task_id', 'id');
    }

    /**
     * Get the comments associated with this task.
     *
     * @return HasMany
     */
    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class, 'task_id', 'id');
    }
}
