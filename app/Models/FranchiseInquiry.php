<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseInquiry extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'postal_code',
        'has_independent_activity',
        'geographic_sector',
        'personal_contribution',
        'message',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'has_independent_activity' => 'boolean',
        ];
    }
}
