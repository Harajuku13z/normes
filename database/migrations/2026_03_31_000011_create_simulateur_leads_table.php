<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simulateur_leads', function (Blueprint $table) {
            $table->id();
            $table->string('nom_prenom', 190)->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->decimal('surface_m2', 8, 2)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('email', 190)->nullable();
            $table->string('service_slug', 190)->nullable();
            $table->string('service_title', 190)->nullable();
            $table->string('sub_service', 190)->nullable();
            $table->text('message')->nullable();
            $table->json('photos')->nullable();
            $table->string('status', 30)->default('draft');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simulateur_leads');
    }
};
