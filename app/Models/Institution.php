<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Province;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'description',
        'address',
        'institution_type',
        'logo',
        'favicon',
        'website',
        'email',
        'phone',
        'primary_color',
        'secondary_color',
        'facebook_url',
        'instagram_url',
        'x_url',
        'linkedin_url',
        'province_id',
    ];
    
    protected function casts(): array
    {
        return [
            'institution_type' => 'string',
        ];
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
