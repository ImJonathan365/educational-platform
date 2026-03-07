<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Province Model
 *
 * Represents a province/state in the system.
 *
 * @property int $id
 * @property string $name Province name
 * @property string|null $code Province code
 * @property bool $active Whether the province is active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @method static Builder active()
 * @method static Builder inactive()
 */
class Province extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'code',
        'active'
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active provinces.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive provinces.
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
            ->setDescriptionForEvent(fn(string $eventName) => "Province {$eventName}");
    }
}
