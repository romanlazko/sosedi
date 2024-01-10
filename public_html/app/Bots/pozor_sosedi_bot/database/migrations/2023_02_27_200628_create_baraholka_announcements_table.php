<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baraholka_announcements', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('telegram_chat_id')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->string('cost')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->string('condition')->nullable();
            $table->unsignedBigInteger('views')->default('0');
            $table->string('status')->default('new')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baraholka_announcements');
    }
};
