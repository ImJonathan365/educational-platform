<?php

namespace App\Filament\Resources\ActivityLogResource;

use App\Filament\Resources\ActivityLogResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Spatie\Activitylog\Models\Activity;
use BackedEnum;
use App\Filament\Resources\ActivityLogResource\Pages\ListActivityLogs;
use App\Filament\Resources\ActivityLogResource\Pages\ViewActivityLog;
use Filament\Actions\ViewAction;

/**
 * ActivityLogResource
 * 
 * Filament resource for viewing activity logs (audit trail).
 * Only super_admin can access this resource.
 * 
 * @package App\Filament\Resources
 */
class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getNavigationLabel(): string
    {
        return __('Activity Log');
    }

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'description';

    /**
     * Define the table for listing activity logs.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('log_name')
                    ->label('Log')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Institution created' => 'success',
                        'Institution updated' => 'warning',
                        'Institution deleted' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn (?string $state): string => 
                        $state ? class_basename($state) : 'N/A'
                    )
                    ->sortable()
                    ->searchable(),

                TextColumn::make('subject_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->sortable()
                    ->searchable(['causer.name', 'causer.email']),

                IconColumn::make('event')
                    ->label('Event')
                    ->icon(fn (?string $state): string => match ($state) {
                        'created' => 'heroicon-o-plus-circle',
                        'updated' => 'heroicon-o-pencil-square',
                        'deleted' => 'heroicon-o-trash',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Date & Time')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('log_name')
                    ->label('Log Name')
                    ->options([
                        'default' => 'Default',
                    ]),

                SelectFilter::make('subject_type')
                    ->label('Model')
                    ->options([
                        'App\\Models\\Institution' => 'Institution',
                    ]),

                SelectFilter::make('event')
                    ->label('Event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }

    /**
     * Define the infolist for viewing activity log details.
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Activity Details')
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),

                        TextEntry::make('log_name')
                            ->label('Log Name')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('description')
                            ->label('Description')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Institution created' => 'success',
                                'Institution updated' => 'warning',
                                'Institution deleted' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('event')
                            ->label('Event Type')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'created' => 'success',
                                'updated' => 'warning',
                                'deleted' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2),

                Section::make('Subject Information')
                    ->schema([
                        TextEntry::make('subject_type')
                            ->label('Model Type')
                            ->formatStateUsing(fn (?string $state): string => 
                                $state ? class_basename($state) : 'N/A'
                            ),

                        TextEntry::make('subject_id')
                            ->label('Model ID'),
                    ])
                    ->columns(2),

                Section::make('User Information')
                    ->schema([
                        TextEntry::make('causer.name')
                            ->label('User Name')
                            ->default('System'),

                        TextEntry::make('causer.email')
                            ->label('User Email')
                            ->default('N/A'),
                    ])
                    ->columns(2),

                Section::make('Changes')
                    ->schema([
                        KeyValueEntry::make('properties.attributes')
                            ->label('New Values')
                            ->columnSpanFull()
                            ->visible(fn ($record) => !empty($record->properties['attributes'] ?? [])),

                        KeyValueEntry::make('properties.old')
                            ->label('Old Values')
                            ->columnSpanFull()
                            ->visible(fn ($record) => !empty($record->properties['old'] ?? [])),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('batch_uuid')
                            ->label('Batch UUID')
                            ->placeholder('N/A'),

                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('Y-m-d H:i:s'),
                    ])
                    ->columns(2),
            ]);
    }

    /**
     * Get the pages for this resource.
     */
    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
            'view' => ViewActivityLog::route('/{record}'),
        ];
    }
}
