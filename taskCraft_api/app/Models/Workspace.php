<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Workspace extends Model
{
    use HasFactory;

    protected $table = 'workspaces';

    protected $fillable = ['name', 'type', 'description'];

    /**
     * Define a many-to-many relationship between the TaskCraft.io application's current class instance and the User model.
     * The relationship represents users associated with the workspace.
     * The intermediate table used is 'workspace_user', and it includes a custom pivot column 'workspace_user_role_id'.
     * Timestamps for the pivot table entries are managed by Laravel.
     *
     * @return BelongsToMany A many-to-many relationship instance representing users associated with the workspace.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'workspace_user')
            ->withPivot('workspace_user_role_id')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(WorkspaceUserRole::class, 'workspace_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    /**
     * Getting all members
     * @return BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(WorkspaceUserRole::class, 'workspace_user')->where('role_name', 'Member');
    }

    /**
     * Getting all members
     * @return BelongsToMany
     */
    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(WorkspaceUserRole::class, 'workspace_user')->where('role_name', 'Guest');
    }


    /**
     * Get the boards associated with this instance.
     *
     * @return HasMany
     */
    public function boards(): HasMany
    {
        return $this->hasMany(Board::class);
    }
}
