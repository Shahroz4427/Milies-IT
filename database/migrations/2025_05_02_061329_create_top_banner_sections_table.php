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
        Schema::create('top_banner_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('landing_page_id');
            $table->string('headline')->nullable();
            $table->json('highlights')->nullable();
            $table->string('testimonial_image')->nullable();
            $table->string('trusted_logos')->nullable(); 
            $table->string('hero_background_image')->nullable(); 
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_banner_sections');
    }
};
