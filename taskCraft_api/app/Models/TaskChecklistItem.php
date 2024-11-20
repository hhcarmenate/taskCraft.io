<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskChecklistItem extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $table = 'task_checklist_items';

    protected $fillable = [
        'checklist_id',
        'description',
        'completed',
    ];


    /**
     * Retrieve the task associated with this instance.
     *
     * @return BelongsTo The task relationship.
     */
    public function taskChecklist(): BelongsTo
    {
        return $this->belongsTo(TaskChecklist::class, 'checklist_id', 'id');
    }

}
