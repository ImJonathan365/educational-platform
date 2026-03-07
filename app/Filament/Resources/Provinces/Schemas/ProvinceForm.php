<?php

namespace App\Filament\Resources\Provinces\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProvinceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Province Information'))
                    ->description(__('Enter the province details. This information will be used throughout the system.'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Province Name'))
                            ->required()
                            ->minLength(2)
                            ->maxLength(100)
                            ->unique(table: 'provinces', column: 'name', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => __('The province name must be unique.'),
                                'required' => __('The province name is required.'),
                                'min' => __('The province name must be at least 2 characters.'),
                                'max' => __('The province name cannot exceed 100 characters.'),
                            ]),
                        TextInput::make('code')
                            ->label(__('Province Code'))
                            ->default(null)
                            ->minLength(2)
                            ->maxLength(10)
                            ->unique(table: 'provinces', column: 'code', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => __('The province code must be unique.'),
                                'min' => __('The province code must be at least 2 characters.'),
                                'max' => __('The province code cannot exceed 10 characters.'),
                            ]),
                    ]),
                Section::make(__('Status'))
                    ->description(__('Set the status of this province. Inactive provinces will not be available for selection in related forms.'))
                    ->icon('heroicon-o-flag')
                    ->schema([
                        Toggle::make('active')
                            ->label(__('Active'))
                            ->default(true)
                            ->inline(false)
                            ->helperText(__('Toggle to activate or deactivate this province'))
                            ->validationMessages([
                                'boolean' => __('Active must be true or false.'),
                            ]),
                    ]),
            ]);
    }
}
