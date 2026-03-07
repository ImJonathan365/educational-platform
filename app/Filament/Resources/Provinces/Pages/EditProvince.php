<?php

namespace App\Filament\Resources\Provinces\Pages;

use App\Filament\Resources\Provinces\ProvinceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditProvince extends EditRecord
{
    protected static string $resource = ProvinceResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public function mount(string|int $record): void
    {
        if (!static::canAccess()) {
            abort(403, __('You do not have permission to edit province/state settings.'));
        }

        parent::mount($record);
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('Province/State settings updated successfully');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back to list'))
                ->url($this->getResource()::getUrl('index')),

            ViewAction::make(),
            DeleteAction::make()
                ->successNotificationTitle(__('Province/State deleted successfully'))
                ->visible(fn () => auth()->user()?->hasRole('super_admin') ?? false),
        ];
    }
}
