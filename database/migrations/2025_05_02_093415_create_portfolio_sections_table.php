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
        Schema::create('portfolio_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('landing_page_id');
            $table->string('name')->nullable();
            $table->string('section_title');
            $table->text('section_description')->nullable();
            $table->json('portfolio_items')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_sections');
    }
};
