<?php

namespace App\Helpers;

use App\Models\Institution;

/**
 * Institution Helper
 * 
 * Provides convenient access to institution settings throughout the application.
 * Uses caching to minimize database queries.
 * 
 * @package App\Helpers
 */
class InstitutionHelper
{
    /**
     * Get the cached institution instance.
     * 
     * Usage:
     *   $institution = InstitutionHelper::get();
     *   echo $institution->name;
     *   echo $institution->logoUrl;
     *
     * @return Institution|null
     */
    public static function get(): ?Institution
    {
        return Institution::cached();
    }

    /**
     * Get the institution name.
     *
     * @return string|null
     */
    public static function name(): ?string
    {
        return self::get()?->name;
    }

    /**
     * Get the institution logo URL.
     *
     * @return string|null
     */
    public static function logo(): ?string
    {
        return self::get()?->logoUrl;
    }

    /**
     * Get the institution favicon URL.
     *
     * @return string|null
     */
    public static function favicon(): ?string
    {
        return self::get()?->faviconUrl;
    }

    /**
     * Get the institution primary color.
     *
     * @return string
     */
    public static function primaryColor(): string
    {
        return self::get()?->primary_color ?? '#009dff';
    }

    /**
     * Get the institution secondary color.
     *
     * @return string
     */
    public static function secondaryColor(): string
    {
        return self::get()?->secondary_color ?? '#ffda09';
    }

    /**
     * Get the institution email.
     *
     * @return string|null
     */
    public static function email(): ?string
    {
        return self::get()?->email;
    }

    /**
     * Get the institution phone.
     *
     * @return string|null
     */
    public static function phone(): ?string
    {
        return self::get()?->phone;
    }

    /**
     * Get the institution website.
     *
     * @return string|null
     */
    public static function website(): ?string
    {
        return self::get()?->website;
    }

    /**
     * Get the institution address.
     *
     * @return string|null
     */
    public static function address(): ?string
    {
        return self::get()?->address;
    }

    /**
     * Get all social media URLs.
     *
     * @return array
     */
    public static function socialMedia(): array
    {
        $institution = self::get();
        
        return array_filter([
            'facebook' => $institution?->facebook_url,
            'instagram' => $institution?->instagram_url,
            'x' => $institution?->x_url,
            'linkedin' => $institution?->linkedin_url,
        ]);
    }

    /**
     * Check if the institution has a logo.
     *
     * @return bool
     */
    public static function hasLogo(): bool
    {
        return !empty(self::get()?->logo);
    }

    /**
     * Check if the institution has a favicon.
     *
     * @return bool
     */
    public static function hasFavicon(): bool
    {
        return !empty(self::get()?->favicon);
    }

    /**
     * Clear the institution cache.
     *
     * @return void
     */
    public static function clearCache(): void
    {
        Institution::clearCache();
    }
}
