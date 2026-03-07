<?php

namespace App\Filament\Resources\Provinces\Pages;

use App\Filament\Resources\Provinces\ProvinceResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateProvince extends CreateRecord
{
    protected static string $resource = ProvinceResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public function mount(): void
    {
        if (!static::canAccess()) {
            abort(403, __('You do not have permission to create provinces/states.'));
        }
        
        $this->authorizeAccess();
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('Province/State created successfully');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back to list'))
                ->url($this->getResource()::getUrl('index')),
        ];
    }

}
