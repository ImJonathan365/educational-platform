<?php

namespace App\Filament\Resources\Institutions;

use App\Filament\Resources\Institutions\Pages\ViewInstitution;
use App\Filament\Resources\Institutions\Pages\EditInstitution;
use App\Filament\Resources\Institutions\Schemas\InstitutionFormSchema;
use App\Filament\Resources\Institutions\Schemas\InstitutionInfolistSchema;
use App\Models\Institution;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InstitutionResource extends Resource
{
    protected static ?string $model = Institution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationLabel(): string
    {
        return __('Institution');
    }

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }
    
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InstitutionFormSchema::make($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstitutionInfolistSchema::make($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ViewInstitution::route('/'),
            'edit' => EditInstitution::route('/edit'),
        ];
    }
}

