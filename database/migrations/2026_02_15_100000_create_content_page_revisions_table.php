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
        Schema::create('content_page_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_page_id')->constrained('content_pages')->onDelete('cascade');
            $table->foreignId('previous_revision_id')->nullable()->constrained('content_page_revisions')->onDelete('set null');
            $table->string('version');
            $table->longText('title'); // JSON for translations
            $table->longText('content'); // JSON for translations
            $table->text('change_notes')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['content_page_id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_page_revisions');
    }
};

