<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulateurLead extends Model
{
    protected $fillable = [
        'nom_prenom',
        'code_postal',
        'surface_m2',
        'address',
        'telephone',
        'email',
        'service_slug',
        'service_title',
        'selected_services',
        'sub_service',
        'selected_sub_services',
        'message',
        'photos',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'photos' => 'array',
        'selected_services' => 'array',
        'selected_sub_services' => 'array',
        'completed_at' => 'datetime',
        'surface_m2' => 'decimal:2',
    ];
}
