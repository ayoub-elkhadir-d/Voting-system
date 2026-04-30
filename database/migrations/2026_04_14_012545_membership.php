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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')
                  ->constrained('rooms')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('username')->nullable();
            $table->string('role')->default('member');
            $table->string('status')->default('active'); 
           

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};