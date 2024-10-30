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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();
            $table->dateTime('birth_date')->nullable();
            $table->string('timezone')->nullable();
            $table->string('job_position')->nullable();
            $table->enum('language', ['ES', 'EN'])->default('EN');
            $table->enum('ui_mode', ['light', 'dark', 'system'])->default('dark');
            $table->json('notification_preference')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
