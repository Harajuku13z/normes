<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The blog_posts table was originally seeded from a SQLite backup which caused
 * MySQL to infer column lengths from data instead of using the migration definition.
 * This migration restores the intended column types.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('title', 255)->change();
            $table->text('excerpt')->nullable()->change();
            $table->string('featured_image', 255)->nullable()->change();
            $table->string('meta_title', 255)->nullable()->change();
            $table->text('meta_description')->nullable()->change();
            $table->string('og_image', 255)->nullable()->change();
            $table->text('meta_keywords')->nullable()->change();
        });
    }

    public function down(): void
    {
        // No rollback — restoring short lengths would lose data
    }
};
