<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkspaceUser extends Model
{
    protected $fillable = ['workspace_id', 'user_id', 'workspace_user_role_id'];

    protected $table = 'workspace_user';
}
