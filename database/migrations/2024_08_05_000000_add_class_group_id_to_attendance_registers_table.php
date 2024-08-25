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
        Schema::table('attendance_registers', function (Blueprint $table) {
            $table->uuid('class_group_id')->after('child_id')->nullable();
            $table->foreign('class_group_id')->references('id')->on('class_groups')->onDelete('set null');
            
            $table->boolean('present')->after('class_group_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_registers', function (Blueprint $table) {
            $table->dropForeign(['class_group_id']);
            $table->dropColumn('class_group_id');
            $table->dropColumn('present');
        });
    }
};