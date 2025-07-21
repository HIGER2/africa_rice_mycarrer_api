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
        Schema::create('employee_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->integer('employeeId');   
            $table->foreign('employeeId')->references('employeeId')->on('employees')->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('relationship')->nullable();
            $table->date('birthday')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_second')->nullable();
            $table->decimal('percentage_share', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_beneficiaries');
    }
};
