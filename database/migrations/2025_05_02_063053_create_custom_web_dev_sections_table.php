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
        Schema::create('custom_web_dev_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('landing_page_id');
            $table->string('section_heading')->nullable();
            $table->text('subheading')->nullable();
            $table->json('services')->nullable();
            $table->timestamps();
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_web_dev_sections');
    }
};
