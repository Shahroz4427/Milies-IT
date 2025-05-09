<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomWebDevSectionResource\Pages;
use App\Filament\Resources\CustomWebDevSectionResource\RelationManagers;
use App\Models\CustomWebDevSection;
use App\Models\LandingPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, Repeater, Grid, Section, FileUpload, Select, DatePicker};
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class CustomWebDevSectionResource extends Resource
{
    protected static ?string $model = CustomWebDevSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Custom Web Development';

    protected static ?int $navigationSort = 4;


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
                                            ->orWhereDoesntHave('customWebDevSection');
                                    });
                                } else {
                                    $query->whereDoesntHave('customWebDevSection');
                                }
                                return $query->pluck('title', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                    ]),
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('section_heading')
                                    ->label('Heading')
                                    ->required()
                                    ->columnSpan(2),
                                Textarea::make('subheading')
                                    ->label('Subheading')
                                    ->required()
                                    ->columnSpan(2),
                            ])
                    ]),
                Section::make('Services')
                    ->schema([
                        Repeater::make('services')
                            ->label('Services')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required(),

                                FileUpload::make('icon')
                                    ->label('Icon Image')
                                    ->image()
                                    ->imagePreviewHeight('60')
                                    ->maxSize(1024)
                                    ->directory('uploads/icons')
                                    ->required(),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->rows(4),
                            ])
                            ->minItems(1)
                            ->maxItems(10)
                            ->addActionLabel('Add Service')
                            ->itemLabel('Service'),
                    ]),
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

                Tables\Columns\TextColumn::make('section_heading')
                    ->label('Heading')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('subheading')
                    ->label('Subheading')
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


                Filter::make('heading')
                    ->form([
                        TextInput::make('section_heading')->placeholder('Search heading'),
                    ])
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when($data['section_heading'], fn($q, $heading) => $q->where('section_heading', 'like', "%{$heading}%"))
                    )
                    ->indicateUsing(
                        fn(array $data) =>
                        filled($data['section_heading']) ? 'Heading: ' . $data['section_heading'] : null
                    ),

                Filter::make('subheading')
                    ->form([
                        TextInput::make('subheading')->placeholder('Search subheading'),
                    ])
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when($data['subheading'], fn($q, $sub) => $q->where('subheading', 'like', "%{$sub}%"))
                    )
                    ->indicateUsing(
                        fn(array $data) =>
                        filled($data['subheading']) ? 'Sub Heading: ' . $data['subheading'] : null
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
            'index' => Pages\ListCustomWebDevSections::route('/'),
            'create' => Pages\CreateCustomWebDevSection::route('/create'),
            'edit' => Pages\EditCustomWebDevSection::route('/{record}/edit'),
        ];
    }
}
