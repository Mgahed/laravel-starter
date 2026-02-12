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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ulid')->unique();
            $table->string('company_name');
            $table->string('general_manager');
            $table->string('health_approval_number');
            $table->text('full_address');
            $table->string('landline')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('whatsapp_enabled')->default(true);
            $table->string('website')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('vat_no')->nullable();
            $table->string('eori_no')->nullable();
            $table->string('logo_path')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};

