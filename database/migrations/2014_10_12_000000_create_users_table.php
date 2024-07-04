<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('title');
            $table->string('address')->nullable();
            $table->string('civic_code')->nullable(); 
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('emergency_person1')->nullable();
            $table->string('emergency_phone1')->nullable();
            $table->string('emergency_person1_relationship')->nullable();
            $table->string('emergency_person2')->nullable();
            $table->string('emergency_phone2')->nullable();
            $table->string('emergency_person2_relationship')->nullable();
            $table->string('cv')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
