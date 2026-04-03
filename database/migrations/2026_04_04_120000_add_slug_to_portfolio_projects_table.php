<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->unique()->after('title');
        });

        $rows = DB::table('portfolio_projects')->orderBy('id')->get(['id', 'title']);
        $seen = [];
        foreach ($rows as $row) {
            $base = Str::slug((string) $row->title) ?: 'realisation';
            $slug = $base;
            $n = 2;
            while (isset($seen[$slug])) {
                $slug = $base.'-'.$n;
                $n++;
            }
            $seen[$slug] = true;
            DB::table('portfolio_projects')->where('id', $row->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
