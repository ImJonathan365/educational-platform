<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Country Model
 *
 * Represents a country in the system.
 *
 * @property int $id
 * @property string $name Country name
 * @property string $code Country code (ISO or custom)
 * @property bool $active Whether the country is active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Institution> $institutions
 * @property-read int $institutions_count
 *
 * @method static Builder active()
 * @method static Builder inactive()
 */
class Country extends Model
{
    use HasFactory, LogsActivity;

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

    /**
     * Get all institutions in this country.
     */
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }

    /**
     * Scope a query to only include active countries.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive countries.
     */
    public function scopeInactive(Builder $query): void
    {
        $query->where('active', false);
    }

    /**
     * Configure the activity log options.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'code',
                'active',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Country {$eventName}");
    }
}
