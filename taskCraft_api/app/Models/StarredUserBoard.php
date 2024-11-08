<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StarredUserBoard extends Model
{
    protected $table = 'starred_user_board';

    protected $fillable = [
        'user_id',
        'board_id',
        'is_starred',
    ];

    /**
     * Retrieve the user that this method belongs to.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retrieve the user that this method belongs to.
     *
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
