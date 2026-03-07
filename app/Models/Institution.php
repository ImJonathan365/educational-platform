<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Province;
use App\Models\Country;

/**
 * Class Institution
 * 
 * Represents a single educational institution in the system.
 * Only one institution record should exist at any time (single-tenant pattern).
 * 
 * @property int $id
 * @property string $name Institution name
 * @property string|null $slogan Institution slogan/motto
 * @property string|null $institution_code Unique institution code
 * @property string|null $description Brief description of the institution
 * @property string|null $address Physical address
 * @property string|null $postal_code Postal/ZIP code
 * @property string $institution_type Type: 'public' or 'private'
 * @property string|null $logo Path to logo file
 * @property string|null $favicon Path to favicon file
 * @property string|null $website Website URL
 * @property string|null $email Contact email (unique)
 * @property string|null $phone Contact phone number
 * @property string $primary_color Primary brand color (hex)
 * @property string $secondary_color Secondary brand color (hex)
 * @property string|null $facebook_url Facebook profile URL
 * @property string|null $instagram_url Instagram profile URL
 * @property string|null $x_url X/Twitter profile URL
 * @property string|null $linkedin_url LinkedIn profile URL
 * @property int|null $province_id Foreign key to provinces table
 * @property int|null $country_id Foreign key to countries table
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read Province|null $province
 * @property-read Country|null $country
 * @property-read string|null $logoUrl Full URL to logo
 * @property-read string|null $faviconUrl Full URL to favicon
 * 
 * @package App\Models
 */
class Institution extends Model
{
    use HasFactory, LogsActivity;

    /**
     * Cache key for the institution instance.
     */
    const CACHE_KEY = 'institution_instance';

    /**
     * Cache duration in seconds (1 hour).
     */
    const CACHE_DURATION = 3600;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slogan',
        'institution_code',
        'description',
        'address',
        'country_id',
        'postal_code',
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

    /**
     * Boot the model and add validation.
     */
    protected static function boot(): void
    {
        parent::boot();
        
        static::creating(function ($institution) {
            if (static::count() > 0) {
                throw new \Exception('Only one institution can exist in the system. Please edit the existing institution instead.');
            }
        });

        static::saved(function ($institution) {
            Cache::forget(self::CACHE_KEY);
        });

        static::deleted(function ($institution) {
            Cache::forget(self::CACHE_KEY);
        });
    }

    /**
     * Get the cached institution instance.
     * 
     * @return Institution|null
     */
    public static function cached(): ?Institution
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return static::with(['country', 'province'])->first();
        });
    }

    /**
     * Clear the institution cache.
     * 
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'institution_type' => 'string',
        ];
    }

    /**
     * Get the province that the institution belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the country that the institution belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the full URL for the logo.
     *
     * @return Attribute
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->logo ? asset('storage/' . $this->logo) : null
        );
    }

    /**
     * Get the full URL for the favicon.
     *
     * @return Attribute
     */
    protected function faviconUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->favicon ? asset('storage/' . $this->favicon) : null
        );
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
                'slogan',
                'institution_code',
                'description',
                'address',
                'postal_code',
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
                'country_id',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Institution {$eventName}");
    }
}
