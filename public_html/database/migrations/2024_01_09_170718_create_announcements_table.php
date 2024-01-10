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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('telegram_chat_id')->nullable();
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('term')->nullable();
            $table->string('cost')->nullable();
            $table->string('kauce')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('views')->default('0');
            $table->string('status')->default('new')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
