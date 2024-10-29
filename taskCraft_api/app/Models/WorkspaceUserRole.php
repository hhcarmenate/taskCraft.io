<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
