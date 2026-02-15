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
        Schema::create('content_pages', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->unique();
            $table->string('slug')->unique()->index();
            $table->string('version')->nullable();
            $table->longText('title'); // JSON for translations
            $table->longText('content'); // JSON for translations
            $table->boolean('is_published')->default(false);
            $table->integer('record_order')->default(100);
            $table->integer('record_state')->default(1);
            $table->integer('protected')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_pages');
    }
};

