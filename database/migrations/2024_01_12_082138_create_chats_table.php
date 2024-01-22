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
            // $table->id();
            // $table->string('message');
            // $table->unsignedBigInteger('created_by');
            // $table->foreignId('created_by')->reference('id')->on('users');
            // $table->unsignedBigInteger('receiver_id')->nullable();
            // $table->foreignId('receiver_id')->reference('id')->on('users');
            // $table->unsignedBigInteger('channel_id')->nullable();
            // $table->foreignId('channel_id')->reference('id')->on('channels');
            // $table->unsignedBigInteger('communitie_id');
            // $table->foreignId('communitie_id')->reference('id')->on('communities');
            // $table->timestamps();
            $table->id();
            $table->string('message');
            $table->unsignedBigInteger('created_by')->index(); // Define the column and create an index
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('receiver_id')->nullable()->index(); // Define the column and create an index
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->unsignedBigInteger('channel_id')->nullable()->index(); // Define the column and create an index
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->unsignedBigInteger('communitie_id')->index(); // Define the column and create an index
            $table->foreign('communitie_id')->references('id')->on('communities');
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
