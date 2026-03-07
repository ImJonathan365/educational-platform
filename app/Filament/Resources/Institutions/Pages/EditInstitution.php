<?php

namespace App\Filament\Resources\Institutions\Pages;

use App\Filament\Resources\Institutions\InstitutionResource;
use App\Models\Institution;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditInstitution extends EditRecord
{
    protected static string $resource = InstitutionResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public function mount(int | string $record = null): void
    {
        if (!static::canAccess()) {
            abort(403, __('You do not have permission to edit institution settings.'));
        }

        $this->record = Institution::firstOrFail();
        
        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewDetails')
                ->label(__('View Details'))
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => $this->getResource()::getUrl('index')),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('Institution settings updated successfully');
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
