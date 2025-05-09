<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinalCTASectionResource\Pages;
use App\Filament\Resources\FinalCTASectionResource\RelationManagers;
use App\Models\FinalCTASection;
use App\Models\LandingPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Section, Select};
use Filament\Tables\Filters\Filter;

class FinalCTASectionResource extends Resource
{
    protected static ?string $model = FinalCTASection::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Final CTA';

    protected static ?int $navigationSort = 11;
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
                                            ->orWhereDoesntHave('finalCTASection');
                                    });
                                } else {
                                    $query->whereDoesntHave('finalCTASection');
                                }

                                return $query->pluck('title', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Section::make('CTA Content')
                    ->schema([
                        TextInput::make('heading')
                            ->label('Heading')
                            ->required(),

                        TextInput::make('button_text')
                            ->label('Button Text')
                            ->required(),
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

                Tables\Columns\TextColumn::make('heading')
                    ->label('Heading')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('button_text')
                    ->label('Button Text')
                    ->sortable(),
            ])
            ->filters([


                Tables\Filters\SelectFilter::make('landing_page_id')
                ->label('Landing Page')
                ->relationship('landingPage', 'title'),

                // Filter for Heading
                Filter::make('heading')
                    ->form([
                        TextInput::make('heading')
                            ->placeholder('Search by heading'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['heading'],
                            fn(Builder $query, $heading): Builder => $query->where('heading', 'like', "%{$heading}%")
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return filled($data['heading']) ? 'Heading: ' . $data['heading'] : null;
                    }),

                // Filter for Button Text
                Filter::make('button_text')
                    ->form([
                        TextInput::make('button_text')
                            ->placeholder('Search by button text'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['button_text'],
                            fn(Builder $query, $buttonText): Builder => $query->where('button_text', 'like', "%{$buttonText}%")
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return filled($data['button_text']) ? 'Button Text: ' . $data['button_text'] : null;
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
            'index' => Pages\ListFinalCTASections::route('/'),
            'create' => Pages\CreateFinalCTASection::route('/create'),
            'edit' => Pages\EditFinalCTASection::route('/{record}/edit'),
        ];
    }
}
