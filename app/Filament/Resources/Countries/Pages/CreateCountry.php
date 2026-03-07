<?php

namespace App\Filament\Resources\Countries\Pages;

use App\Filament\Resources\Countries\CountryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return __('Country created successfully');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back to list'))
                ->url($this->getResource()::getUrl('index')),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public function mount(): void
    {
        if (!static::canAccess()) {
            abort(403, __('You do not have permission to create countries.'));
        }
        
        $this->authorizeAccess();
    }
}
