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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('traccar_id')->unique();
            $table->string('name');
            $table->string('unique_id')->unique();
            $table->string('status')->nullable();
            $table->timestamp('last_update')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('model')->nullable();
            $table->string('contact')->nullable();
            $table->string('category')->nullable();
            $table->boolean('disabled')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->json('attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
