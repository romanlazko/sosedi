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
        Schema::create('announcement_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('announcement_id')->nullable();
            $table->index('announcement_id', 'photo_announcement_idx');
            $table->foreign('announcement_id', 'photo_announcement_fk')->on('announcements')->references('id');

            $table->string('file_id')->nullable();
            $table->string('url')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_photos');
    }
};
