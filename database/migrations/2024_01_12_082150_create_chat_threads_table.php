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
        Schema::create('chat_threads', function (Blueprint $table) {
            // $table->id();
            // $table->string('message');
            // $table->unsignedBigInteger('chat_id');
            // $table->foreignId('chat_id')->reference('id')->on('chats');
            // $table->unsignedBigInteger('created_by');
            // $table->foreignId('created_by')->reference('id')->on('users');
            // $table->timestamps();

            $table->id();
            $table->string('message');
            $table->unsignedBigInteger('chat_id')->index(); // Define the column and create an index
            $table->foreign('chat_id')->references('id')->on('chats');
            $table->unsignedBigInteger('created_by')->index(); // Define the column and create an index
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_threads');
    }
};
