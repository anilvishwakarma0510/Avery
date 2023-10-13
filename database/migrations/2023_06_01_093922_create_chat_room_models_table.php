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
        Schema::create('chat_room', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender')->nullable();
            $table->foreign('sender')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('receiver')->nullable();
            $table->foreign('receiver')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('blog_id')->nullable();
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('set NULL')->onUpdate('set NULL');

            $table->string('thread_id')->nullable();
            $table->longText('message')->nullable();
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('chat_type')->default(0)->comment('1=blog chat,0 one to one');
            $table->tinyInteger('is_delivered')->default(0)->comment('0=no,1=yes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_room');
    }
};
