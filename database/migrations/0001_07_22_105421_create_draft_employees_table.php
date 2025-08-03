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
        Schema::create('draft_employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('recrutement_id')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('country_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('nationality_1')->nullable();
            $table->string('nationality_2')->nullable();
            $table->string('indentity_number')->nullable();
            $table->string('social_security_number')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('country_of_residence')->nullable();
            $table->string('town_of_residence')->nullable();
            $table->string('phone')->nullable();
            $table->string('personal_email')->unique()->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->string('number_of_children')->nullable();
            $table->string('family_living_with_staff')->nullable();
            $table->string('family_residence_location')->nullable();
            $table->string('spouse_works')->nullable();
            $table->string('spouse_workplace')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_employees');
    }
};
