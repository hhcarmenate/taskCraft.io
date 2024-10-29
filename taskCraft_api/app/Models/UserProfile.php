<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = ['user_id'];

    /**
     *
     * Retrieve the user associated with the current instance.
     *
     * @return BelongsTo The relationship instance representing the associated user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
