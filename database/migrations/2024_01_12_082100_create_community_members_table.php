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
        Schema::create('community_members', function (Blueprint $table) {
            // $table->id();
            // $table->string('role');
            // $table->enum('status', ['Pending', 'Active']);
            // $table->unsignedBigInteger('user_id');
            // $table->foreignId('user_id')->reference('id')->on('users');
            // $table->unsignedBigInteger('communitie_id');
            // $table->foreignId('communitie_id')->reference('id')->on('communities');
            // $table->timestamps();
            $table->id();
            $table->string('role');
            $table->enum('status', ['Pending', 'Active']);
            $table->unsignedBigInteger('user_id')->index(); // Define the column and create an index
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('community_members');
    }
};
