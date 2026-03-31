<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('simulateur_leads', function (Blueprint $table) {
            $table->string('source_page', 255)->nullable()->after('address');
            $table->timestamp('admin_notified_started_at')->nullable()->after('completed_at');
            $table->timestamp('admin_notified_completed_at')->nullable()->after('admin_notified_started_at');
            $table->timestamp('client_notified_at')->nullable()->after('admin_notified_completed_at');
            $table->text('mail_error')->nullable()->after('client_notified_at');
        });
    }

    public function down(): void
    {
        Schema::table('simulateur_leads', function (Blueprint $table) {
            $table->dropColumn([
                'source_page',
                'admin_notified_started_at',
                'admin_notified_completed_at',
                'client_notified_at',
                'mail_error',
            ]);
        });
    }
};
