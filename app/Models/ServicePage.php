<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePage extends Model
{
    protected $fillable = [
        'service_num',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
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
        'service_partners',
        'technical_doc',
        'cta_text',
        'cta_href',
        'cta_card_background',
        'is_active',
    ];

    protected $casts = [
        'sub_services' => 'array',
        'realisations' => 'array',
        'service_partners' => 'array',
    ];
}

