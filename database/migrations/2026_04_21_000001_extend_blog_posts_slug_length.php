<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Extend slug from varchar(42) to varchar(255) to support long article slugs
            $table->string('slug', 255)->nullable()->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('slug', 42)->nullable()->unique()->change();
        });
    }
};
