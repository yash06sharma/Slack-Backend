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
        Schema::create('chat_attachments', function (Blueprint $table) {
            // $table->id();
            // $table->string('name');
            // $table->string('path');
            // $table->string('type');
            // $table->unsignedBigInteger('chat_id')->nullable();
            // $table->foreignId('chat_id')->reference('id')->on('chats');
            // $table->unsignedBigInteger('created_by');
            // $table->foreignId('created_by')->reference('id')->on('users');
            // $table->unsignedBigInteger('chat_thread_id')->nullable();
            // $table->foreignId('chat_thread_id')->reference('id')->on('chat_threads');
            // $table->timestamps();
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->string('type');
            $table->unsignedBigInteger('chat_id')->nullable()->index(); // Define the column and create an index
            $table->foreign('chat_id')->references('id')->on('chats');
            $table->unsignedBigInteger('created_by')->index(); // Define the column and create an index
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('chat_thread_id')->nullable()->index(); // Define the column and create an index
            $table->foreign('chat_thread_id')->references('id')->on('chat_threads');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_attachments');
    }
};
