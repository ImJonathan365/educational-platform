<?php

namespace App\Filament\Resources\Countries\Pages;

use App\Filament\Resources\Countries\CountryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewCountry extends ViewRecord
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back to list'))
                ->url($this->getResource()::getUrl('index')),

            EditAction::make()
                ->label(__('Edit Country'))
                ->icon('heroicon-o-pencil-square')
                ->visible(fn () => auth()->user()?->hasRole('super_admin') ?? false),
        ];
    }
}
