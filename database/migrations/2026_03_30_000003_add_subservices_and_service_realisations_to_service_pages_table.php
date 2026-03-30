<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->json('sub_services')->nullable()->after('featured_image');
            $table->json('realisations')->nullable()->after('sub_services');
        });
    }

    public function down(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->dropColumn(['realisations', 'sub_services']);
        });
    }
};

