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
        Schema::create('child_guardian', function (Blueprint $table) {
            $table->id();
            
            $table->uuid('child_id');
            $table->uuid('guardian_id');
            
            // $table->foreign('child_id')->references('id')
            //      ->on('children')->onDelete('cascade');
            // $table->foreign('guardian_id')->references('id')
            //     ->on('guardians')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_guardian');
    }
};
