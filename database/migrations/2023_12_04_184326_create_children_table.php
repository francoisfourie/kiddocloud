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
        Schema::create('children', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('surname');
            $table->date('date_of_birth');
            $table->string('id_number')->nullable();
            $table->string('gender');
            $table->string('home_language');
            $table->string('medical_condition')->nullable();
            $table->text('medication')->nullable();
            $table->text('allergies')->nullable();
            $table->uuid('company_id');
            $table->uuid('class_group_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
