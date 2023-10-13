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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category')->nullable();
            $table->foreign('category')->references('id')->on('category')->onDelete('set null')->onUpdate('set null');
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('media_type')->nullable();
            $table->string('media_file')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=inactive, 1 = active');
            $table->text('sort_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
