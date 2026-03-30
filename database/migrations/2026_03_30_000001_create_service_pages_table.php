<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_num')->nullable();
            $table->string('slug')->unique();

            $table->string('title')->default('');
            $table->string('subtitle')->nullable();
            $table->text('intro')->nullable();
            $table->longText('body')->nullable();

            $table->string('image')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_href')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_pages');
    }
};

