<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @mixin IdeHelperWorkspaceUserRole
 * @property int $id
 * @property string $role_name
 * @property string $role_description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Workspace> $workspaces
 * @property-read int|null $workspaces_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkspaceUserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkspaceUserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkspaceUserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkspaceUserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkspaceUserRole whereRoleDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkspaceUserRole whereRoleName($value)
 * @mixin \Eloquent
 */
class WorkspaceUserRole extends Model
{
    protected $fillable = ['role_name', 'role_description'];

    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'workspace_user')
            ->withPivot('workspace_id')
            ->withTimestamps();
    }
}
