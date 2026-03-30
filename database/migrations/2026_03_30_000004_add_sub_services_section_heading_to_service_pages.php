<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->string('sub_services_section_title')->nullable()->after('sub_services');
            $table->text('sub_services_section_intro')->nullable()->after('sub_services_section_title');
        });
    }

    public function down(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->dropColumn(['sub_services_section_intro', 'sub_services_section_title']);
        });
    }
};
