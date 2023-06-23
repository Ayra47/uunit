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
        Schema::create('folder', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->string('folder_name');
            $table->foreignId('user_id')->references('id')->on('users');
        });

        Schema::create('file', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->string('path');
            $table->foreignId('folder_id')->references('id')->on('folder');
        });

        Schema::create('file_error', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->foreignId('file_id')->references('id')->on('file');
            $table->integer('page');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_error');
        Schema::dropIfExists('file');
        Schema::dropIfExists('folder');
    }
};
