<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'code' => 'string',
            'active' => 'boolean',
        ];
    }

    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }

}
