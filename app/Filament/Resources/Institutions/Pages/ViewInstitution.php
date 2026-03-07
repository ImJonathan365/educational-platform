<?php

namespace App\Filament\Resources\Institutions\Pages;

use App\Filament\Resources\Institutions\InstitutionResource;
use App\Models\Institution;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInstitution extends ViewRecord
{
    protected static string $resource = InstitutionResource::class;

    public function mount(int | string $record = null): void
    {
        $this->record = Institution::firstOrFail();
        
        $this->authorizeAccess();
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label(__('Edit Institution'))
                ->icon('heroicon-o-pencil-square')
                ->visible(fn () => auth()->user()?->hasRole('super_admin') ?? false),
        ];
    }
}
