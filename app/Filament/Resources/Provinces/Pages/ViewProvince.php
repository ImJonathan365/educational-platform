<?php

namespace App\Filament\Resources\Provinces\Pages;

use App\Filament\Resources\Provinces\ProvinceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewProvince extends ViewRecord
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back to list'))
                ->url($this->getResource()::getUrl('index')),

            EditAction::make()
                ->label(__('Edit Province/State'))
                ->icon('heroicon-o-pencil-square')
                ->visible(fn () => auth()->user()?->hasRole('super_admin') ?? false),
        ];
    }
}
