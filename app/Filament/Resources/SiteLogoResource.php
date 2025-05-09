<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteLogoResource\Pages;
use App\Filament\Resources\SiteLogoResource\RelationManagers;
use App\Models\LandingPage;
use App\Models\SiteLogo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\{Select, FileUpload, Grid,};

class SiteLogoResource extends Resource
{
    protected static ?string $model = SiteLogo::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';


    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Site Logos';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Select::make('landing_page_id')
                            ->label('Landing Page')
                            ->options(function ($get, $record) {
                                $query = LandingPage::query();
                                if ($record) {
                                    $query->where(function ($q) use ($record) {
                                        $q->where('id', $record->landing_page_id)
                                            ->orWhereDoesntHave('siteLogo');
                                    });
                                } else {
                                    $query->whereDoesntHave('siteLogo');
                                }

                                return $query->pluck('title', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Grid::make(1)
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('site-logos')
                            ->imagePreviewHeight('100')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('Landing Page')
                    ->label('Landing Page')
                    ->getStateUsing(fn($record) => $record->landingPage->slug)
                    ->url(fn($record) => url('/' . $record->landingPage->slug))
                    ->openUrlInNewTab()
                    ->toggleable(),

                ImageColumn::make('logo')
                    ->label('Logo')
                    ->height(50)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state) => $state ? $state->format('Y-m-d H:i') : ''),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('landing_page_id')
                    ->label('Landing Page')
                    ->relationship('landingPage', 'title')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListSiteLogos::route('/'),
            'create' => Pages\CreateSiteLogo::route('/create'),
            'edit' => Pages\EditSiteLogo::route('/{record}/edit'),
        ];
    }
}