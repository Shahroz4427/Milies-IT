<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialSectionResource\Pages;
use App\Filament\Resources\TestimonialSectionResource\RelationManagers;
use App\Models\LandingPage;
use App\Models\TestimonialSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Section, TextInput, Textarea, Repeater, Grid, Select};
use Filament\Tables\Filters\Filter;

class TestimonialSectionResource extends Resource
{
    protected static ?string $model = TestimonialSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Testimonial';

    protected static ?int $navigationSort = 10;

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
                                            ->orWhereDoesntHave('testimonialSection');
                                    });
                                } else {
                                    $query->whereDoesntHave('testimonialSection');
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

                Section::make('Section Info')
                    ->schema([
                        TextInput::make('section_title')
                            ->label('Section Title')
                            ->required(),

                        TextInput::make('section_subtitle')
                            ->label('Section Subtitle'),
                    ]),

                Section::make('Client Testimonials')
                    ->description('Add client reviews with name, company, rating, and feedback.')
                    ->schema([
                        Repeater::make('testimonials')
                            ->label('Testimonials')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('client_name')
                                            ->label('Client Name')
                                            ->required(),

                                        Select::make('star_rating')
                                            ->label('Star Rating')
                                            ->options([
                                                1 => '1 Star',
                                                2 => '2 Stars',
                                                3 => '3 Stars',
                                                4 => '4 Stars',
                                                5 => '5 Stars',
                                            ])
                                            ->required(),
                                    ]),
                                Textarea::make('testimonial_text')
                                    ->label('Testimonial Text')
                                    ->rows(4)
                                    ->required(),
                            ])
                            ->addActionLabel('Add Testimonial')
                            ->columns(1),
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

                Tables\Columns\TextColumn::make('section_title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('section_subtitle')
                    ->label('Subtitle')
                    ->limit(60),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('landing_page_id')
                    ->label('Landing Page')
                    ->relationship('landingPage', 'title'),


                Filter::make('section_title')
                    ->form([
                        TextInput::make('section_title')
                            ->placeholder('Search by section title'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['section_title'],
                            fn(Builder $query, $sectionTitle): Builder => $query->where('section_title', 'like', "%{$sectionTitle}%")
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return filled($data['section_title']) ? 'Section Title: ' . $data['section_title'] : null;
                    }),

                Filter::make('section_subtitle')
                    ->form([
                        TextInput::make('section_subtitle')
                            ->placeholder('Search by section subtitle'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['section_subtitle'],
                            fn(Builder $query, $sectionSubtitle): Builder => $query->where('section_subtitle', 'like', "%{$sectionSubtitle}%")
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return filled($data['section_subtitle']) ? 'Section Subtitle: ' . $data['section_subtitle'] : null;
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
            'index' => Pages\ListTestimonialSections::route('/'),
            'create' => Pages\CreateTestimonialSection::route('/create'),
            'edit' => Pages\EditTestimonialSection::route('/{record}/edit'),
        ];
    }
}