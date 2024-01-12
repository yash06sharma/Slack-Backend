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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->unsignedBigInteger('created_by');
            $table->foreignId('created_by')->reference('id')->on('users');
            $table->unsignedBigInteger('receiver_id');
            $table->foreignId('receiver_id')->reference('id')->on('users');
            $table->unsignedBigInteger('channel_id');
            $table->foreignId('channel_id')->reference('id')->on('channels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
