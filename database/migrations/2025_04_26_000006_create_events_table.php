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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('location', 255)->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->text('detail')->nullable();
            $table->integer('capacity');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('organizer_id')->constrained('users');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
