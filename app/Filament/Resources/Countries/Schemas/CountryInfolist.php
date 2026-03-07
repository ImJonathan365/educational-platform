<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class CountryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Country Details'))
                    ->description(__('Detailed information about the country. This information is used throughout the system and can be edited as needed.'))
                    ->icon('heroicon-o-globe-americas')
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Country Name')),
                        TextEntry::make('code')
                            ->label(__('Country Code')),
                        IconEntry::make('active')
                            ->label(__('Active'))
                            ->boolean(),
                    ]),
                Section::make(__('Timestamps'))
                    ->description(__('The dates when this country was created and last updated.'))
                    ->icon('heroicon-o-clock')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
