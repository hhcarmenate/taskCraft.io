<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('workspace_user_roles', function(Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->text('role_description');
        });

        Schema::create('workspace_user', function(Blueprint $table) {
           $table->id();
           $table->foreignId('workspace_id')->constrained()->onDelete('cascade');
           $table->foreignId('user_id')->constrained()->onDelete('cascade');
           $table->foreignId('workspace_user_role_id')->constrained()->onDelete('cascade');
           $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspace');
        Schema::dropIfExists('workspace_user');
        Schema::dropIfExists('workspace_user_role');
    }
};
