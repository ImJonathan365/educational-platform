<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;

/**
 * ListActivityLogs
 * 
 * Page for listing all activity logs.
 * 
 * @package App\Filament\Resources\ActivityLogResource\Pages
 */
class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    public function getTitle(): string
    {
        return __('Activity Log');
    }

    /**
     * Get the header actions for this page.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
