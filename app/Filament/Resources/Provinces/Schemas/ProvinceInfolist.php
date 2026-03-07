<?php

namespace App\Filament\Resources\Provinces\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProvinceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Province Information'))
                    ->description(__('Detailed information about the province. This information is used throughout the system and can be edited as needed.'))
                    ->icon('heroicon-o-map')
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Province Name')),
                        TextEntry::make('code')
                            ->label(__('Province Code'))
                            ->placeholder('-'),
                        IconEntry::make('active')
                            ->label(__('Active'))
                            ->boolean(),
                    ]),
                Section::make(__('Timestamps'))
                    ->description(__('The dates when this province was created and last updated.'))
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
