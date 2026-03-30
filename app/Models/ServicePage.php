<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePage extends Model
{
    protected $fillable = [
        'service_num',
        'slug',
        'title',
        'subtitle',
        'intro',
        'body',
        'image',
        'featured_image',
        'sub_services',
        'sub_services_section_title',
        'sub_services_section_intro',
        'realisations',
        'cta_text',
        'cta_href',
        'is_active',
    ];

    protected $casts = [
        'sub_services' => 'array',
        'realisations' => 'array',
    ];
}

