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
        Schema::create('employee_payrolls', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->integer('employee_id')->nullable();
            $table->foreign('employee_id')->references('employeeId')->on('employees')->onDelete('cascade');
            $table->foreignId('recrutement_id')->nullable()->constrained('recrutements')->nullOnDelete();

            $table->enum('is_active', ['active', 'inactive'])->default('active');

            $table->date('date')->nullable();
            $table->decimal('basic_salary', 15, 2)->nullable();
            $table->decimal('salary_currency', 15, 2)->nullable();
            $table->decimal('salary_frequency')->nullable();
            $table->decimal('transport_allowance', 15, 2)->nullable();
            $table->decimal('housing_allowance', 15, 2)->nullable();
            $table->decimal('dependent_allowance', 15, 2)->nullable();
            $table->decimal('installation_allowance', 15, 2)->nullable();
            $table->decimal('arrival_shipping_allowance', 15, 2)->nullable();
            $table->decimal('departure_shipping_allowance', 15, 2)->nullable();
            $table->decimal('health_insurance', 15, 2)->nullable();
            $table->decimal('social_contribution', 15, 2)->nullable();
            $table->decimal('life_insurance', 15, 2)->nullable();
            $table->decimal('salary_taxes', 15, 2)->nullable();

            $table->enum('home_leave', ['yes', 'no'])->default('no');
            $table->enum('flight_ticket', ['yes', 'no'])->default('no');
            $table->enum('installation_assistance', ['yes', 'no'])->default('no');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_payrolls');
    }
};
