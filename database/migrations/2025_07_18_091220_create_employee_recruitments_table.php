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
        Schema::create('employee_recruitments', function (Blueprint $table) {
            $table->id();
            $table->integer('employeeId');
            $table->foreign('employeeId')->references('employeeId')->on('employees')->onDelete('cascade');
            
            $table->string('center')->nullable(); // AfricaRice/Hosted
            $table->string('country_duty_station')->nullable();
            $table->string('city_duty_station')->nullable();
            $table->string('position_title')->nullable();
            $table->string('recruitment_id')->nullable();
            $table->date('contract_from')->nullable();
            $table->date('contract_to')->nullable();
            $table->string('grade')->nullable();
            $table->string('division')->nullable();
            $table->string('program')->nullable();
            $table->string('sub_unit')->nullable();
            $table->string('education_level')->nullable();
            $table->string('resources_type')->nullable();
            $table->enum('contract_time', ['Full time', 'Part time'])->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_position')->nullable();
            $table->string('recruitment_type')->nullable();
            $table->string('country_of_recruitment')->nullable();
            $table->string('cgiar_workforce_group')->nullable();
            $table->string('cgiar_group')->nullable();
            $table->boolean('cgiar_appointed')->default(false);
            $table->decimal('percent_time_other_center', 5, 2)->nullable(); // Ex: 25.00
            $table->boolean('shared_working_arrangement')->default(false);
            $table->string('initiative_lead')->nullable();
            $table->string('initiative_personnel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_recruitments');
    }
};
