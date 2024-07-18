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
        Schema::create('feminine_health_worker_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feminine_id');
            $table->unsignedBigInteger('health_worker_id');
            $table->timestamps();

            $table->foreign('feminine_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('health_worker_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feminine_health_worker_groups');
    }
};
