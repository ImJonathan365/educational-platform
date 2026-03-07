<?php

namespace App\Filament\Resources\Institutions\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class InstitutionFormSchema
{
    public static function make(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::generalInformationSection(),
                self::locationContactSection(),
                self::brandingSection(),
                self::socialMediaSection(),
            ]);
    }

    private static function generalInformationSection(): Section
    {
        return Section::make(__('General Information'))
            ->description(__('Basic details about your institution to help users understand what your institution is about.'))
            ->icon('heroicon-o-building-library')
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Institution Name'))
                            ->required()
                            ->minLength(3)
                            ->maxLength(200)
                            ->unique(ignoreRecord: true)
                            ->autocomplete(false)
                            ->validationMessages([
                                'required' => __('Institution name is required.'),
                                'min' => __('Institution name must be at least 3 characters.'),
                                'max' => __('Institution name cannot exceed 200 characters.'),
                                'unique' => __('This institution name is already in use.'),
                            ])
                            ->columnSpan(2),
                        TextInput::make('slogan')
                            ->label(__('Slogan'))
                            ->minLength(3)
                            ->maxLength(100)
                            ->autocomplete(false)
                            ->validationMessages([
                                'min' => __('Slogan must be at least 3 characters.'),
                                'max' => __('Slogan cannot exceed 100 characters.'),
                            ]),
                    ]),
                Grid::make(2)
                    ->schema([
                        Select::make('institution_type')
                            ->label(__('Institution Type'))
                            ->options([
                                'public' => __('Public'),
                                'private' => __('Private'),
                            ])
                            ->required()
                            ->native(false)
                            ->default('public')
                            ->validationMessages([
                                'required' => __('Please select the institution type.'),
                            ]),
                        TextInput::make('institution_code')
                            ->label(__('Institution Code'))
                            ->alphaDash()
                            ->unique(ignoreRecord: true)
                            ->minLength(3)
                            ->maxLength(50)
                            ->placeholder(__('MIE-001'))
                            ->validationMessages([
                                'alpha_dash' => __('Institution code can only contain letters, numbers, dashes, and underscores.'),
                                'min' => __('Institution code must be at least 3 characters.'),
                                'max' => __('Institution code cannot exceed 50 characters.'),
                                'unique' => __('This institution code is already in use.'),
                            ]),
                    ]),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->rows(4)
                    ->minLength(10)
                    ->maxLength(1000)
                    ->placeholder(__('A brief overview of your institution'))
                    ->validationMessages([
                        'min' => __('Description must be at least 10 characters.'),
                        'max' => __('Description cannot exceed 1000 characters.'),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->collapsible();
    }

    private static function locationContactSection(): Section
    {
        return Section::make(__('Location & Contact'))
            ->description(__('Information about your institution\'s location and contact details.'))
            ->icon('heroicon-o-map-pin')
            ->schema([
                Textarea::make('address')
                    ->label(__('Address'))
                    ->rows(2)
                    ->minLength(10)
                    ->maxLength(500)
                    ->placeholder(__('Full street address'))
                    ->validationMessages([
                        'min' => __('Address must be at least 10 characters.'),
                        'max' => __('Address cannot exceed 500 characters.'),
                    ])
                    ->columnSpanFull(),
                
                Select::make('country_id')
                    ->label(__('Country'))
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required()
                    ->exists(table: 'countries', column: 'id')
                    ->validationMessages([
                        'required' => __('Please select a country.'),
                        'exists' => __('The selected country does not exist.'),
                    ])
                    ->columnSpan(1),
                Select::make('province_id')
                    ->label(__('Province/State'))
                    ->relationship('province', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->exists(table: 'provinces', column: 'id')
                    ->validationMessages([
                        'exists' => __('The selected province does not exist.'),
                    ])
                    ->columnSpan(1),
                TextInput::make('postal_code')
                    ->label(__('Postal Code'))
                    ->minLength(4)
                    ->maxLength(20)
                    ->alphaDash()
                    ->placeholder(__('10101'))
                    ->validationMessages([
                        'alpha_dash' => __('Postal code can only contain letters, numbers, dashes, and underscores.'),
                        'min' => __('Postal code must be at least 4 characters.'),
                        'max' => __('Postal code cannot exceed 20 characters.'),
                        ])
                    ->columnSpan(1),
                
                TextInput::make('website')
                    ->label(__('Website'))
                    ->url()
                    ->suffixIcon('heroicon-o-globe-alt')
                    ->placeholder(__('https://www.example.com'))
                    ->minLength(10)
                    ->maxLength(255)
                    ->validationMessages([
                        'url' => __('Please enter a valid URL starting with http:// or https://'),
                        'min' => __('Website URL must be at least 10 characters.'),
                        'max' => __('Website URL cannot exceed 255 characters.'),
                    ])
                    ->columnSpan(1),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->required()
                    ->suffixIcon('heroicon-o-envelope')
                    ->placeholder(__('contact@institution.edu'))
                    ->maxLength(150)
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => __('This email is already in use.'),
                        'email' => __('Please enter a valid email address.'),
                        'required' => __('Email is required.'),
                        'max' => __('Email cannot exceed 150 characters.'),
                    ])
                    ->columnSpan(1),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel()
                    ->suffixIcon('heroicon-o-phone')
                    ->placeholder(__('+506 2222-2222'))
                    ->minLength(8)
                    ->maxLength(20)
                    ->regex('/^[+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/')
                    ->validationMessages([
                        'min' => __('Phone number must be at least 8 characters.'),
                        'max' => __('Phone number cannot exceed 20 characters.'),
                        'regex' => __('Please enter a valid phone number format.'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3)
            ->collapsible();
    }

    private static function brandingSection(): Section
    {
        return Section::make('Branding')
            ->description(__('Branding elements to customize the appearance of your institution on the platform.'))
            ->icon('heroicon-o-paint-brush')
            ->schema([
                Grid::make(1)
                    ->schema([
                        ViewField::make('logo_preview')
                            ->label(__('Current Logo'))
                            ->view('filament.forms.components.image-preview')
                            ->extraAttributes(['class' => 'col-span-full text-center'])
                            ->viewData(fn ($record) => [
                                'imagePath' => $record?->logo,
                                'imageStyle' => 'max-height: 200px; max-width: 500px;',
                                'objectFit' => 'object-contain',
                            ])
                            ->visible(fn ($record) => $record?->logo),
                        
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('logo')
                                    ->label(fn ($record) => $record?->logo ? __('Replace Logo') : __('Upload Logo'))
                                    ->image()
                                    ->directory('institutions/logos')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'])
                                    ->maxSize(2048)
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('1920')
                                    ->imageResizeTargetHeight('1080')
                                    ->imagePreviewHeight('150')
                                    ->afterStateHydrated(fn ($set) => $set('logo', null))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->validationMessages([
                                        'image' => __('The file must be an image.'),
                                        'max' => __('The image size cannot exceed 2MB.'),
                                    ]),
                                
                                TextInput::make('delete_logo')
                                    ->label(__('Remove Current Logo'))
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder(__('Click action button to remove'))
                                    ->suffixAction(self::makeImageDeleteAction('logo'))
                                    ->visible(fn ($record) => $record?->logo),
                            ]),
                    ])
                    ->columnSpanFull(),

                Grid::make(1)
                    ->schema([
                        ViewField::make('favicon_preview')
                            ->label(__('Current Favicon'))
                            ->view('filament.forms.components.image-preview')
                            ->extraAttributes(['class' => 'col-span-full text-center'])
                            ->viewData(fn ($record) => [
                                'imagePath' => $record?->favicon,
                                'imageStyle' => 'width: 120px; height: 120px;',
                                'objectFit' => 'object-contain',
                            ])
                            ->visible(fn ($record) => $record?->favicon),
                        
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('favicon')
                                    ->label(fn ($record) => $record?->favicon ? __('Replace Favicon') : __('Upload Favicon'))
                                    ->image()
                                    ->directory('institutions/favicons')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/svg+xml'])
                                    ->maxSize(512)
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('64')
                                    ->imageResizeTargetHeight('64')
                                    ->imagePreviewHeight('120')
                                    ->afterStateHydrated(fn ($set) => $set('favicon', null))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->validationMessages([
                                        'image' => __('The file must be an image.'),
                                        'max' => __('The favicon size cannot exceed 512KB.'),
                                    ]),
                                
                                TextInput::make('delete_favicon')
                                    ->label(__('Remove Current Favicon'))
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder(__('Click action button to remove'))
                                    ->suffixAction(self::makeImageDeleteAction('favicon'))
                                    ->visible(fn ($record) => $record?->favicon),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Grid::make(2)
                    ->schema([
                        ColorPicker::make('primary_color')
                            ->label(__('Primary Color'))
                            ->required()
                            ->default('#009dff')
                            ->regex('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/')
                            ->validationMessages([
                                'regex' => __('Please enter a valid hex color (e.g., #009dff)'),
                                'required' => __('Primary color is required.'),
                            ]),
                        ColorPicker::make('secondary_color')
                            ->label(__('Secondary Color'))
                            ->required()
                            ->default('#ffda09')
                            ->regex('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/')
                            ->validationMessages([
                                'regex' => __('Please enter a valid hex color (e.g., #ffda09)'),
                                'required' => __('Secondary color is required.'),
                            ]),
                    ]),
            ])
            ->columns(2)
            ->collapsible();
    }

    private static function socialMediaSection(): Section
    {
        return Section::make(__('Social Media'))
            ->description(__('Social media profiles to connect your institution with its online presence and allow users to easily find and follow you.'))
            ->icon('heroicon-o-share')
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->suffixIcon('heroicon-o-globe-alt')
                            ->placeholder('https://facebook.com/yourpage')
                            ->maxLength(255)
                            ->regex('/^https?:\/\/(www\.)?(facebook|fb)\.com\/.+$/i')
                            ->validationMessages([
                                'regex' => __('Please enter a valid Facebook URL'),
                                'max' => __('URL cannot exceed 255 characters'),
                            ]),
                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->suffixIcon('heroicon-o-globe-alt')
                            ->placeholder('https://instagram.com/yourprofile')
                            ->maxLength(255)
                            ->regex('/^https?:\/\/(www\.)?instagram\.com\/.+$/i')
                            ->validationMessages([
                                'regex' => __('Please enter a valid Instagram URL'),
                                'max' => __('URL cannot exceed 255 characters'),
                            ]),
                        TextInput::make('x_url')
                            ->label('X (Twitter)')
                            ->url()
                            ->suffixIcon('heroicon-o-globe-alt')
                            ->placeholder('https://x.com/yourprofile')
                            ->maxLength(255)
                            ->regex('/^https?:\/\/(www\.)?(x\.com|twitter\.com)\/.+$/i')
                            ->validationMessages([
                                'regex' => __('Please enter a valid X/Twitter URL'),
                                'max' => __('URL cannot exceed 255 characters'),
                            ]),
                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->url()
                            ->suffixIcon('heroicon-o-globe-alt')
                            ->placeholder('https://linkedin.com/company/yourcompany')
                            ->maxLength(255)
                            ->regex('/^https?:\/\/(www\.)?linkedin\.com\/.+$/i')
                            ->validationMessages([
                                'regex' => __('Please enter a valid LinkedIn URL'),
                                'max' => __('URL cannot exceed 255 characters'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->collapsible()
            ->columns(2);
    }

    private static function makeImageDeleteAction(string $field): Action
    {
        $fieldLabel = $field === 'logo' ? __('Logo') : __('Favicon');
        
        return Action::make("delete" . ucfirst($field))
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading(__('Delete :field', ['field' => $fieldLabel]))
            ->modalDescription(__('Are you sure you want to delete this :field? This action cannot be undone.', ['field' => strtolower($fieldLabel)]))
            ->modalSubmitActionLabel(__('Delete'))
            ->action(function ($record, $set) use ($field) {
                if ($record && $record->{$field}) {
                    $path = $record->{$field};
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $record->{$field} = null;
                    $record->save();
                    $set($field, null);
                }
            });
    }
}
