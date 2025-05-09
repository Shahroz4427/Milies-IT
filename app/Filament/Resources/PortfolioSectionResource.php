<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioSectionResource\Pages;
use App\Filament\Resources\PortfolioSectionResource\RelationManagers;
use App\Models\LandingPage;
use App\Models\PortfolioSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, Repeater, Section, FileUpload, Select};
use Filament\Tables\Filters\Filter;

class PortfolioSectionResource extends Resource
{
    protected static ?string $model = PortfolioSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Portfolio';

    protected static ?int $navigationSort = 9;


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
                                            ->orWhereDoesntHave('portfolioSection');
                                    });
                                } else {
                                    $query->whereDoesntHave('portfolioSection');
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

                Section::make('Portfolio Section')
                    ->schema([
                        TextInput::make('section_title')
                            ->label('Section Title')
                            ->required(),

                        Repeater::make('portfolio_items')
                            ->label('Portfolio Items')
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->label('Image')
                                    ->required(),
                            ])
                            ->addActionLabel('Add Portfolio Item'),
                    ])
                    ->columns(1),
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
            ])
            ->filters([
                // Filter by Landing Page
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
            'index' => Pages\ListPortfolioSections::route('/'),
            'create' => Pages\CreatePortfolioSection::route('/create'),
            'edit' => Pages\EditPortfolioSection::route('/{record}/edit'),
        ];
    }
}
