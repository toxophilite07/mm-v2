<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpVerificationsTable extends Migration
{
    public function up()
    {
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();  // Store the email for OTP verification
            $table->string('otp');  // Store the OTP value
            $table->timestamp('expires_at');  // OTP expiration time
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('otp_verifications');
    }
}
