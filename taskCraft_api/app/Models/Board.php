<?php

namespace App\Models;

use App\Observers\Board\BoardObserver;
use App\Traits\RegisterObserverTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    /** @use HasFactory<\Database\Factories\BoardFactory> */
    use HasFactory, RegisterObserverTrait;
    protected $table = 'boards';

    protected $fillable = [
        'title',
        'workspace_id',
        'visibility',
    ];

    /**
     * @return BoardObserver
     */
    public static function getObserverClass(): BoardObserver
    {
        return new BoardObserver();
    }

    /**
     * Get the workspace that this entity belongs to.
     *
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id', 'id');
    }

    /**
     * Get the lists associated with this board.
     *
     * @return HasMany
     */
    public function lists(): HasMany
    {
        return $this->hasMany(BoardList::class, 'board_id', 'id');
    }
}
