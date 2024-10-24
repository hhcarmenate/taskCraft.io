<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @mixin IdeHelperWorkspace
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkspaceUserRole> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workspace whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Workspace extends Model
{
    /** @use HasFactory<\Database\Factories\WorkSpaceFactory> */
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
}
