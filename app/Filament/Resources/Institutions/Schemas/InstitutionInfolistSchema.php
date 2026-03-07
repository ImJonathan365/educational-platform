<?php

namespace App\Filament\Resources\Institutions\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class InstitutionInfolistSchema
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
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Institution Name'))
                            ->icon('heroicon-o-building-library')
                            ->columnSpan(2),
                        TextEntry::make('institution_type')
                            ->label(__('Type'))
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'public' => __('Public'),
                                'private' => __('Private'),
                                default => $state,
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'public' => 'success',
                                'private' => 'info',
                                default => 'gray',
                            }),
                    ]),
                TextEntry::make('slogan')
                    ->label(__('Slogan'))
                    ->placeholder(__('No slogan set'))
                    ->icon('heroicon-o-sparkles'),
                TextEntry::make('institution_code')
                    ->label(__('Institution Code'))
                    ->placeholder(__('No code set'))
                    ->icon('heroicon-o-hashtag'),
                TextEntry::make('description')
                    ->label(__('Description'))
                    ->placeholder(__('No description provided'))
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->collapsible();
    }

    private static function locationContactSection(): Section
    {
        return Section::make(__('Location & Contact'))
            ->schema([
                TextEntry::make('address')
                    ->label(__('Address'))
                    ->placeholder(__('No address set'))
                    ->icon('heroicon-o-map-pin')
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        TextEntry::make('country.name')
                            ->label(__('Country'))
                            ->placeholder(__('Not specified'))
                            ->icon('heroicon-o-globe-alt'),
                        TextEntry::make('province.name')
                            ->label(__('Province/State'))
                            ->placeholder(__('Not specified'))
                            ->icon('heroicon-o-map'),
                        TextEntry::make('postal_code')
                            ->label(__('Postal Code'))
                            ->placeholder(__('Not set'))
                            ->icon('heroicon-o-envelope'),
                    ])
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        TextEntry::make('website')
                            ->label(__('Website'))
                            ->placeholder(__('No website'))
                            ->url(fn ($record) => $record?->website)
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-globe-alt'),
                        TextEntry::make('email')
                            ->label(__('Email'))
                            ->placeholder(__('No email'))
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->label(__('Phone'))
                            ->placeholder(__('No phone'))
                            ->icon('heroicon-o-phone')
                            ->copyable(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(3)
            ->collapsible();
    }

    private static function brandingSection(): Section
    {
        return Section::make(__('Branding'))
            ->schema([
                Grid::make(2)
                    ->schema([
                        ImageEntry::make('logo')
                            ->label(__('Logo'))
                            ->disk('public')
                            ->height(120)
                            ->defaultImageUrl(url('/images/placeholder.png'))
                            ->hidden(fn ($record) => !$record?->logo),
                        TextEntry::make('logo_placeholder')
                            ->label(__('Logo'))
                            ->default(__('No logo uploaded'))
                            ->color('gray')
                            ->icon('heroicon-o-photo')
                            ->hidden(fn ($record) => (bool) $record?->logo),
                        ImageEntry::make('favicon')
                            ->label(__('Favicon'))
                            ->disk('public')
                            ->height(100)
                            ->defaultImageUrl(url('/images/placeholder.png'))
                            ->hidden(fn ($record) => !$record?->favicon),
                        TextEntry::make('favicon_placeholder')
                            ->label(__('Favicon'))
                            ->default(__('No favicon uploaded'))
                            ->color('gray')
                            ->icon('heroicon-o-photo')
                            ->hidden(fn ($record) => (bool) $record?->favicon),
                    ])
                    ->columnSpanFull(),
                Grid::make(2)
                    ->schema([
                        TextEntry::make('primary_color')
                            ->label(__('Primary Color'))
                            ->formatStateUsing(fn ($state) => new HtmlString(
                                '<div class="flex items-center gap-2">' .
                                '<div style="width: 40px; height: 40px; background-color: ' . $state . '; border-radius: 6px; border: 1px solid #e5e7eb;"></div>' .
                                '<span class="font-mono font-semibold">' . strtoupper($state) . '</span>' .
                                '</div>'
                            )),
                        TextEntry::make('secondary_color')
                            ->label(__('Secondary Color'))
                            ->formatStateUsing(fn ($state) => new HtmlString(
                                '<div class="flex items-center gap-2">' .
                                '<div style="width: 40px; height: 40px; background-color: ' . $state . '; border-radius: 6px; border: 1px solid #e5e7eb;"></div>' .
                                '<span class="font-mono font-semibold">' . strtoupper($state) . '</span>' .
                                '</div>'
                            )),
                    ]),
            ])
            ->columns(2)
            ->collapsible();
    }

    private static function socialMediaSection(): Section
    {
        return Section::make(__('Social Media'))
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextEntry::make('facebook_url')
                            ->label(__('Facebook'))
                            ->placeholder(__('Not connected'))
                            ->url(fn ($record) => $record?->facebook_url)
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-globe-alt'),
                        TextEntry::make('instagram_url')
                            ->label(__('Instagram'))
                            ->placeholder(__('Not connected'))
                            ->url(fn ($record) => $record?->instagram_url)
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-globe-alt'),
                        TextEntry::make('x_url')
                            ->label(__('X (Twitter)'))
                            ->placeholder(__('Not connected'))
                            ->url(fn ($record) => $record?->x_url)
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-globe-alt'),
                        TextEntry::make('linkedin_url')
                            ->label(__('LinkedIn'))
                            ->placeholder(__('Not connected'))
                            ->url(fn ($record) => $record?->linkedin_url)
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-globe-alt'),
                    ]),
            ])
            ->columns(2)
            ->collapsible();
    }
}
