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

            if (!Schema::hasColumn('employees', 'uuid')) {
                $table->uuid('uuid')->unique()->nullable();
            }

            if (Schema::hasColumn('employees', 'email')) {
                $table->string('email')->nullable()->default(null)->change();
            }
            
            if (!Schema::hasColumn('employees', 'personal_email')) {
                $table->string('personal_email')->nullable()->unique();
            }

            if (!Schema::hasColumn('employees', 'personalEmail')) {
                $table->string('personalEmail')->nullable()->unique();
            }

            if (!Schema::hasColumn('employees', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }

            if (!Schema::hasColumn('employees', 'country_of_birth')) {
                $table->string('country_of_birth')->nullable();
            }

            if (!Schema::hasColumn('employees', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable();
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
                $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            }

            if (!Schema::hasColumn('employees', 'number_of_children')) {
                $table->integer('number_of_children')->default(0);
            }

            if (!Schema::hasColumn('employees', 'family_living_with_staff')) {
                $table->enum('family_living_with_staff', ['yes', 'no'])->nullable();
            }

            if (!Schema::hasColumn('employees', 'family_residence_location')) {
                $table->string('family_residence_location')->nullable();
            }

            if (!Schema::hasColumn('employees', 'spouse_works')) {
                $table->enum('spouse_works', ['yes', 'no'])->nullable();
            }

            if (!Schema::hasColumn('employees', 'spouse_workplace')) {
                $table->text('spouse_workplace')->nullable();
            }

            // if (!Schema::hasColumn('employees', 'post_id')) {
            //     $table->foreignId('post_id')->nullable()->constrained('posts')->nullOnDelete();
            // }

            // Facultatif : éviter d’ajouter created_at/updated_at si déjà présents
            if (!Schema::hasColumns('employees', ['created_at', 'updated_at'])) {
                $table->timestamps();
            }

            if (!Schema::hasColumn('employees', 'organization')) {
                Schema::table('employees', function (Blueprint $table) {
                    $table->string('organization')->nullable();
                });
            }
            if (!Schema::hasColumn('employees', 'division')) {
                Schema::table('employees', function (Blueprint $table) {
                    $table->string('division')->nullable();
                });
            }
            if (!Schema::hasColumn('employees', 'unit_program')) {
                Schema::table('employees', function (Blueprint $table) {
                    $table->string('unit_program')->nullable();
                });
            }

            if (!Schema::hasColumn('employees', 'base_station')) {
                Schema::table('employees', function (Blueprint $table) {
                    $table->string('base_station')->nullable();
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('email')->nullable(false)->default('')->change();
            });
            $table->dropColumn([
                'email',
                'date_of_birth','uuid', 'country_of_birth', 'gender', 'nationality_1', 'nationality_2',
                'indentity_number', 'social_security_number', 'permanent_address',
                'country_of_residence', 'town_of_residence', 'marital_status', 'number_of_children',
                'family_living_with_staff', 'family_residence_location', 'spouse_works', 'spouse_workplace'
            ]);
        });
    }
};
