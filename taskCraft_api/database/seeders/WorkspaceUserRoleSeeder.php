<?php

namespace Database\Seeders;

use App\Models\WorkspaceUserRole;
use Illuminate\Database\Seeder;

class WorkspaceUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workspaceUserRoles = [
          ['role_name' => 'Owner', 'role_description' => 'This is the workspace owner'],
          ['role_name' => 'Member', 'role_description' => 'This user is part of the workspace'],
          ['role_name' => 'Guest', 'role_description' => 'This is a guest'],
        ];

        WorkspaceUserRole::query()->insert($workspaceUserRoles);
    }
}
