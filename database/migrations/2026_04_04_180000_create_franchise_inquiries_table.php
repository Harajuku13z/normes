<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchise_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 64);
            $table->string('email');
            $table->string('postal_code', 32);
            $table->boolean('has_independent_activity');
            $table->string('geographic_sector', 255);
            $table->string('personal_contribution', 120)->nullable();
            $table->text('message')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchise_inquiries');
    }
};
