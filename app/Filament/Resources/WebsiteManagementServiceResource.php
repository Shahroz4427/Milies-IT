<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebsiteManagementServiceResource\Pages;
use App\Filament\Resources\WebsiteManagementServiceResource\RelationManagers;
use App\Models\LandingPage;
use App\Models\WebsiteManagementService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, Repeater, Section, FileUpload, Select};
use Filament\Tables\Filters\Filter;

class WebsiteManagementServiceResource extends Resource
{
    protected static ?string $model = WebsiteManagementService::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Web Management';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Landing Page')
                    ->schema([
                        Select::make('landing_page_id')
                            ->label('Landing Page')
                            ->options(function ($get, $record) {
                                $query = LandingPage::query();

                                if ($record) {
                                    $query->where(function ($q) use ($record) {
                                        $q->where('id', $record->landing_page_id)
                                            ->orWhereDoesntHave('websiteManagementService');
                                    });
                                } else {
                                    $query->whereDoesntHave('websiteManagementService');
                                }

                                return $query->pluck('title', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Section Name')
                            ->required(),
                    ]),

                Section::make('Website Management Services')
                    ->schema([
                        TextInput::make('title')
                            ->label('Section Title')
                            ->required(),

                        TextInput::make('subtitle')
                            ->label('Section Subtitle'),

                        Repeater::make('services')
                            ->label('Service Cards')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Card Title')
                                    ->required(),

                                FileUpload::make('icon')
                                    ->label('Icon')
                                    ->image()
                                    ->directory('website-management-icons')
                                    ->required(),

                                Textarea::make('description')
                                    ->label('Card Description')
                                    ->rows(3)
                                    ->required(),
                            ])
                            ->addActionLabel('Add Service Card'),
                    ])
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Landing Page')
                    ->label('Landing Page')
                    ->getStateUsing(fn($record) => $record->landingPage->slug)
                    ->url(fn($record) => url('/' . $record->landingPage->slug))
                    ->openUrlInNewTab()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Section Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label(' Title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->sortable()
                    ->limit(60),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('landing_page_id')
                    ->label('Landing Page')
                    ->relationship('landingPage', 'title'),


                Filter::make('title')
                    ->form([
                        TextInput::make('title')
                            ->placeholder('Search by title'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['title'],
                            fn(Builder $query, $title): Builder => $query->where('title', 'like', "%{$title}%")
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return filled($data['title']) ? 'Title: ' . $data['title'] : null;
                    }),

                Filter::make('subtitle')
                    ->form([
                        TextInput::make('subtitle')
                            ->placeholder('Search by subtitle'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['subtitle'],
                            fn(Builder $query, $subtitle): Builder => $query->where('subtitle', 'like', "%{$subtitle}%")
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return filled($data['subtitle']) ? 'Subtitle: ' . $data['subtitle'] : null;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebsiteManagementServices::route('/'),
            'create' => Pages\CreateWebsiteManagementService::route('/create'),
            'edit' => Pages\EditWebsiteManagementService::route('/{record}/edit'),
        ];
    }
}