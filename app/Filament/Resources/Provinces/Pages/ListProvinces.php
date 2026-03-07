<?php

namespace App\Filament\Resources\Provinces\Pages;

use App\Filament\Resources\Provinces\ProvinceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProvinces extends ListRecords
{
    protected static string $resource = ProvinceResource::class;

    public function getTitle(): string
    {
        return __('Provinces/States');
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('Add Province/State'))
                ->visible(fn () => auth()->user()?->hasRole('super_admin') ?? false),
        ];
    }
}
