<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolutionSectionResource\Pages;
use App\Filament\Resources\SolutionSectionResource\RelationManagers;
use App\Models\LandingPage;
use App\Models\SolutionSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, Repeater, Section, FileUpload, Select, DatePicker};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class SolutionSectionResource extends Resource
{
    protected static ?string $model = SolutionSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Web Solutions';

    protected static ?int $navigationSort = 5;

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
                                            ->orWhereDoesntHave('solutionSection');
                                    });
                                } else {
                                    $query->whereDoesntHave('solutionSection');
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
                Section::make('Solutions Section')
                    ->schema([
                        TextInput::make('title')
                            ->label('Section Title')
                            ->required(),
                        TextInput::make('subtitle')
                            ->label('Section Subtitle'),
                        Repeater::make('solutions')
                            ->label('Solution Cards')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Card Title')
                                    ->required(),
                                FileUpload::make('icon')
                                    ->label('Card Icon')
                                    ->image()
                                    ->directory('solution-icons')
                                    ->required(),
                                Textarea::make('description')
                                    ->label('Card Description')
                                    ->required(),
                            ])
                            ->addActionLabel('Add Solution Card')
                            ->minItems(1),
                    ])
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Section Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->limit(50),

                TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([

                SelectFilter::make('landing_page_id')
                    ->label('Landing Page')
                    ->relationship('landingPage', 'title')
                    ->searchable()
                    ->preload(),


                Filter::make('title')
                    ->form([
                        TextInput::make('title')->placeholder('Search title'),
                    ])
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when($data['title'], fn($q, $value) => $q->where('title', 'like', "%{$value}%"))
                    )
                    ->indicateUsing(
                        fn(array $data) =>
                        filled($data['title']) ? 'Title: ' . $data['title'] : null
                    ),

                Filter::make('subtitle')
                    ->form([
                        TextInput::make('subtitle')->placeholder('Search subtitle'),
                    ])
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when($data['subtitle'], fn($q, $value) => $q->where('subtitle', 'like', "%{$value}%"))
                    )
                    ->indicateUsing(
                        fn(array $data) =>
                        filled($data['subtitle']) ? 'Subtitle: ' . $data['subtitle'] : null
                    ),
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
            'index' => Pages\ListSolutionSections::route('/'),
            'create' => Pages\CreateSolutionSection::route('/create'),
            'edit' => Pages\EditSolutionSection::route('/{record}/edit'),
        ];
    }
}