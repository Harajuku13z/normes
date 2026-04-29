<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('simulateur_leads', function (Blueprint $table) {
            // Fix varchar sizes inferred too small from SQLite sample data
            $table->string('nom_prenom', 255)->nullable()->change();
            $table->string('code_postal', 20)->nullable()->change();
            $table->decimal('surface_m2', 8, 2)->nullable()->change();
            $table->string('address', 500)->nullable()->change();
            $table->string('telephone', 50)->nullable()->change();
            $table->string('service_slug', 255)->nullable()->change();
            $table->string('service_title', 255)->nullable()->change();
            $table->string('sub_service', 255)->nullable()->change();
            $table->text('message')->nullable()->change();
            $table->text('photos')->nullable()->change();
            $table->string('source_page', 500)->nullable()->change();
            $table->text('selected_services')->nullable()->change();
            $table->text('selected_sub_services')->nullable()->change();
            $table->string('mail_error', 1000)->nullable()->change();
        });
    }

    public function down(): void
    {
        // No rollback — smaller sizes would break data
    }
};
