<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
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

    public function taskChecklist(): HasOne
    {
        return $this->hasOne(TaskChecklist::class, 'task_id', 'id');
    }

}
