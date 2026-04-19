<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->string('service')->nullable();
            $table->text('message')->nullable();
            $table->text('autres_infos')->nullable();
            $table->json('photos')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('admin_mail_sent')->default(false);
            $table->boolean('client_mail_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_inquiries');
    }
};
