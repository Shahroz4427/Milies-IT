<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingPageResource\Pages;
use App\Filament\Resources\LandingPageResource\RelationManagers;
use App\Models\LandingPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\CreateAction;
use Filament\Forms\Components\{TextInput, Grid};

class LandingPageResource extends Resource
{
    protected static ?string $model = LandingPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Landing Pages';
    protected static ?string $pluralModelLabel = 'Landing Pages';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1)->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->getStateUsing(fn($record) => url('/' . $record->slug))
                    ->url(fn($record) => url('/' . $record->slug))
                    ->openUrlInNewTab()

            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth('sm'),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLandingPages::route('/'),
            // 'create' => Pages\CreateLandingPage::route('/create'),
            // 'edit' => Pages\EditLandingPage::route('/{record}/edit'),
        ];
    }
}
