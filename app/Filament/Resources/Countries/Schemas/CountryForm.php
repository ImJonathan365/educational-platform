<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Country Details'))
                    ->description(__('Enter the details for the country. This information will be used throughout the system.'))
                    ->icon('heroicon-o-globe-americas')
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Country Name'))
                            ->minLength(3)
                            ->maxLength(100)
                            ->placeholder(__('Enter country name'))
                            ->required()
                            ->validationMessages([
                                'required' => __('Country name is required'),
                                'min' => __('Country name must be at least 3 characters'),
                                'max' => __('Country name cannot exceed 100 characters'),
                            ]),
                        TextInput::make('code')
                            ->label(__('Country Code'))
                            ->minLength(2)
                            ->maxLength(3)
                            ->unique(table: 'countries', column: 'code', ignoreRecord: true)
                            ->placeholder(__('Enter country code'))
                            ->alphaDash()
                            ->required()
                            ->validationMessages([
                                'required' => __('Country code is required'),
                                'min' => __('Country code must be at least 2 characters'),
                                'max' => __('Country code cannot exceed 3 characters'),
                                'unique' => __('This country code is already in use'),
                                'alpha_dash' => __('Country code can only contain letters, numbers, dashes and underscores'),
                            ]),
                    ]),
                Section::make(__('Status'))
                    ->description(__('Toggle the active status of this country. Inactive countries will not be available for selection in dropdowns.'))
                    ->icon('heroicon-o-flag')
                    ->schema([
                        Toggle::make('active')
                            ->label(__('Active'))
                            ->default(true)
                            ->inline(false)
                            ->helperText(__('Toggle to activate or deactivate this country'))
                            ->validationMessages([
                                'boolean' => __('Active must be true or false'),
                            ]),
                    ]),
                ]);
    }
}
