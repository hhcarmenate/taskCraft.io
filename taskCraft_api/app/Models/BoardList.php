<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoardList extends Model
{
    /** @use HasFactory<\Database\Factories\BoardFactory> */
    use HasFactory;
    protected $table = 'board_lists';

    protected $fillable = [
        'board_id',
        'title',
        'description',
        'position',
    ];

    /**
     * Get the workspace that this entity belongs to.
     *
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }

    /**
     * Retrieve all tasks associated with this object.
     *
     * @return HasMany A collection of Task objects related to this object.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'list_id', 'id');
    }
}
