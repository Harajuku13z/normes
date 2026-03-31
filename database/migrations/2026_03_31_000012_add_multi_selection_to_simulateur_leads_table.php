<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('simulateur_leads', function (Blueprint $table) {
            $table->json('selected_services')->nullable()->after('service_title');
            $table->json('selected_sub_services')->nullable()->after('sub_service');
        });
    }

    public function down(): void
    {
        Schema::table('simulateur_leads', function (Blueprint $table) {
            $table->dropColumn(['selected_services', 'selected_sub_services']);
        });
    }
};
