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
        Schema::create('menus', function (Blueprint $table) {
			$table->id();
			$table->string('ulid')->unique();
			$table->string('slug')->unique();
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
			$table->json('title');
			$table->string('route')->default('#');
			$table->string('icon')->nullable();
			$table->integer('record_order')->nullable();
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
