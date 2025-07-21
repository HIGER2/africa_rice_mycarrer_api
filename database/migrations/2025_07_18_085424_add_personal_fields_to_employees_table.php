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
    Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }

            if (!Schema::hasColumn('employees', 'country_of_birth')) {
                $table->string('country_of_birth')->nullable();
            }

            if (!Schema::hasColumn('employees', 'gender')) {
                $table->enum('gender', ['Male', 'Female'])->nullable();
            }

            if (!Schema::hasColumn('employees', 'nationality_1')) {
                $table->string('nationality_1')->nullable();
            }

            if (!Schema::hasColumn('employees', 'nationality_2')) {
                $table->string('nationality_2')->nullable();
            }

            if (!Schema::hasColumn('employees', 'indentity_number')) {
                $table->string('indentity_number')->nullable();
            }

            if (!Schema::hasColumn('employees', 'social_security_number')) {
                $table->string('social_security_number')->nullable();
            }

            if (!Schema::hasColumn('employees', 'permanent_address')) {
                $table->text('permanent_address')->nullable();
            }

            if (!Schema::hasColumn('employees', 'country_of_residence')) {
                $table->string('country_of_residence')->nullable();
            }

            if (!Schema::hasColumn('employees', 'town_of_residence')) {
                $table->string('town_of_residence')->nullable();
            }

            if (!Schema::hasColumn('employees', 'marital_status')) {
                $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            }

            if (!Schema::hasColumn('employees', 'number_of_children')) {
                $table->integer('number_of_children')->default(0)->nullable();
            }

            if (!Schema::hasColumn('employees', 'family_living_with_staff')) {
                $table->boolean('family_living_with_staff')->default(true)->nullable();
            }

            if (!Schema::hasColumn('employees', 'family_residence_location')) {
                $table->string('family_residence_location')->nullable();
            }

            if (!Schema::hasColumn('employees', 'spouse_works')) {
                $table->boolean('spouse_works')->default(false)->nullable();
            }

            if (!Schema::hasColumn('employees', 'spouse_workplace')) {
                $table->text('spouse_workplace')->nullable();
            }

            // Facultatif : éviter d’ajouter created_at/updated_at si déjà présents
            if (!Schema::hasColumns('employees', ['created_at', 'updated_at'])) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth', 'country_of_birth', 'gender', 'nationality_1', 'nationality_2',
                'indentity_number', 'social_security_number', 'permanent_address',
                'country_of_residence', 'town_of_residence', 'marital_status', 'number_of_children',
                'family_living_with_staff', 'family_residence_location', 'spouse_works', 'spouse_workplace'
            ]);
        });
    }
};
