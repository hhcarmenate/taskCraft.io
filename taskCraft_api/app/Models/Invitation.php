<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations';

    protected $fillable = [
        'workspace_id',
        'inviter_id',
        'invitee_email',
        'token',
        'status',
        'expires_at',
        'invitation_text',
        'sent'
    ];

    /**
     * Get the workspace that this object belongs to.
     *
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * Get the user who initiated the invitation for this object.
     *
     * @return BelongsTo
     */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id', 'id');
    }
}
