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
            $table->integer('employeeId');
            $table->foreign('employeeId')->references('employeeId')->on('employees')->onDelete('cascade');

            $table->decimal('basic_salary', 15, 2)->nullable();
            $table->string('salary_currency')->nullable();
            $table->string('salary_frequency')->nullable();
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
            $table->boolean('home_leave')->default(false);
            $table->boolean('flight_ticket')->default(false);
            $table->boolean('installation_assistance')->default(false);
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
