<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $fillable = [
        'nom_complet', 'email', 'telephone', 'code_postal',
        'service', 'message', 'autres_infos', 'photos',
        'ip_address', 'admin_mail_sent', 'client_mail_sent',
    ];

    protected $casts = [
        'photos' => 'array',
        'admin_mail_sent' => 'boolean',
        'client_mail_sent' => 'boolean',
    ];
}
