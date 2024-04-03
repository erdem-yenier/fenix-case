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
        Schema::create('chat_box', function (Blueprint $table) {
            $table->id();
            $table->uuid('chat_uuid');
            $table->unsignedBigInteger('user_id');
            $table->enum('user_type', ['chat_bot', 'user']);
            $table->text('chat_content');
            $table->dateTime('chat_date');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_box');
    }
};
