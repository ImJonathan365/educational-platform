<?php

namespace App\Filament\Resources\Countries\Pages;

use App\Filament\Resources\Countries\CountryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('Country settings updated successfully');
    }

    public function mount(string|int $record): void
    {
        if (!static::canAccess()) {
            abort(403, __('You do not have permission to edit country settings.'));
        }

        parent::mount($record);
    }
    
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back to list'))
                ->url($this->getResource()::getUrl('index')),

            ViewAction::make(),
            DeleteAction::make()
                ->successNotificationTitle(__('Country deleted successfully'))
                ->visible(fn () => auth()->user()?->hasRole('super_admin') ?? false),
        ];
    }
}
