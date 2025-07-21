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
        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->id();
            $table->integer('employeeId');
            $table->foreign('employeeId')->references('employeeId')->on('employees')->onDelete('cascade');
            $table->string('resno')->nullable();
            $table->string('position_posno')->nullable();
            $table->string('type_of_contract')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->date('probation_end_date_1')->nullable();
            $table->date('probation_end_date_2')->nullable();
            $table->string('bg_level_equivalent')->nullable();
            $table->string('supervisor_posno')->nullable();
            $table->string('position_classification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};
