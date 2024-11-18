<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // public function up()
    // {
    //     Schema::create('known_devices', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to the users table
    //         $table->string('ip_address');
    //         $table->string('device_name')->nullable();
    //         $table->timestamp('last_used_at')->nullable();
    //         $table->timestamps();
    //     });
    // }

    // public function down()
    // {
    //     Schema::dropIfExists('known_devices');
    // }
};
