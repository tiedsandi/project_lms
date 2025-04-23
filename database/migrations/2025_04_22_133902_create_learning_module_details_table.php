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
        Schema::create('learning_module_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_module_id')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file')->nullable();
            $table->string('reference_link')->nullable();
            $table->timestamps();

            $table->foreign('learning_module_id')
                ->references('id')->on('learning_modules')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_module_details');
    }
};
