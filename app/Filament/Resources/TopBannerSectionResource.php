<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopBannerSectionResource\Pages;
use App\Filament\Resources\TopBannerSectionResource\RelationManagers;
use App\Models\LandingPage;
use App\Models\TopBannerSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Section, TextInput, Textarea, Repeater, FileUpload, Grid, Select};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class TopBannerSectionResource extends Resource
{
    protected static ?string $model = TopBannerSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Top Banner';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Top Banner Section')
                    ->schema([
                        Select::make('landing_page_id')
                            ->label('Landing Page')
                            ->options(function ($get, $record) {
                                $query = LandingPage::query();
                                if ($record) {
                                    $query->where(function ($q) use ($record) {
                                        $q->where('id', $record->landing_page_id)
                                            ->orWhereDoesntHave('topBannerSection');
                                    });
                                } else {
                                    $query->whereDoesntHave('topBannerSection');
                                }

                                return $query->pluck('title', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Grid::make(1)->schema([
                            TextInput::make('headline')
                                ->label('Headline')
                                ->required()
                                ->columnSpan(1),
                        ]),
                        Repeater::make('highlights')
                            ->label('Highlights')
                            ->schema([
                                TextInput::make('value')
                                    ->label('Highlight Text')
                                    ->required(),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Add Highlight')
                            ->columns(1),
                        FileUpload::make('testimonial_image')
                            ->image()
                            ->directory('testimonials')
                            ->label('Testimonial Image')
                            ->required()
                            ->columnSpan(1),
                        FileUpload::make('trusted_logos')
                            ->image()
                            ->directory('trusted-logos')
                            ->label('Trusted Logo')
                            ->required()
                            ->columnSpan(1),
                        FileUpload::make('hero_background_image')
                            ->image()
                            ->directory('hero-backgrounds')
                            ->label('Hero Background Image')
                            ->required()
                            ->columns(1),
                    ])
                    ->columns(1),
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

                TextColumn::make('headline')
                    ->label('Headline')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                ImageColumn::make('hero_background_image')->label('Hero Background Image'),
            ])
            ->filters([
                SelectFilter::make('landing_page_id')
                    ->label('Landing Page')
                    ->relationship('landingPage', 'title')
                    ->searchable()
                    ->preload(),

                Filter::make('headline')
                    ->form([
                        TextInput::make('headline')
                            ->placeholder('Search by headline'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['headline'],
                                fn(Builder $query, $headline): Builder => $query->where('headline', 'like', "%{$headline}%")
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! empty($data['headline'])) {
                            return 'Headline: ' . $data['headline'];
                        }
                        return null;
                    }),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTopBannerSections::route('/'),
            'create' => Pages\CreateTopBannerSection::route('/create'),
            'edit' => Pages\EditTopBannerSection::route('/{record}/edit'),
        ];
    }
}