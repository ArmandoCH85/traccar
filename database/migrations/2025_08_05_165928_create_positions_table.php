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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('traccar_id')->unique();
            $table->unsignedBigInteger('device_id');
            $table->string('protocol')->nullable();
            $table->timestamp('server_time')->nullable();
            $table->timestamp('device_time')->nullable();
            $table->timestamp('fix_time')->nullable();
            $table->boolean('outdated')->default(false);
            $table->boolean('valid')->default(true);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('altitude', 8, 2)->nullable();
            $table->decimal('speed', 8, 2)->nullable();
            $table->decimal('course', 6, 2)->nullable();
            $table->text('address')->nullable();
            $table->decimal('accuracy', 8, 2)->nullable();
            $table->json('network')->nullable();
            $table->json('attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
