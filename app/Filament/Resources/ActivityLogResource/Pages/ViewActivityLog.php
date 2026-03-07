<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource\ActivityLogResource;
use Filament\Resources\Pages\ViewRecord;

/**
 * ViewActivityLog
 * 
 * Page for viewing a single activity log entry.
 * 
 * @package App\Filament\Resources\ActivityLogResource\Pages
 */
class ViewActivityLog extends ViewRecord
{
    protected static string $resource = ActivityLogResource::class;

    /**
     * Get the header actions for this page.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
