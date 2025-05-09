<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsCapabilitiesSectionResource\Pages;
use App\Filament\Resources\CmsCapabilitiesSectionResource\RelationManagers;
use App\Models\CmsCapabilitiesSection;
use App\Models\LandingPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Section, TextInput, Textarea, Repeater, FileUpload, Select};
use Illuminate\Support\Facades\Redirect;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;


class CmsCapabilitiesSectionResource extends Resource
{
    protected static ?string $model = CmsCapabilitiesSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'CMS / Landing Page';

    protected static ?string $navigationLabel = 'Cms Capabilities';

    protected static ?int $navigationSort = 6;

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
                                            ->orWhereDoesntHave('cmsCapabilitiesSection');
                                    });
                                } else {
                                    $query->whereDoesntHave('cmsCapabilitiesSection');
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
                Section::make('CMS Capabilities Section')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),

                        Textarea::make('description')
                            ->label('Description')
                            ->required(),

                        FileUpload::make('logos')
                            ->label('Logos')
                            ->image()
                            ->directory('cms-logos'),

                        Repeater::make('bullet_points')
                            ->label('Bullet Points')
                            ->schema([
                                TextInput::make('value')
                                    ->label('Point')
                                    ->required(),
                            ])
                            ->addActionLabel('Add Point'),
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

                TextColumn::make('name')
                    ->label('Section Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->tooltip(fn($record) => $record->description)
                    ->toggleable()
                    ->html(),
            ])
            ->filters([
                SelectFilter::make('landing_page_id')
                    ->label('Landing Page')
                    ->relationship('landingPage', 'title')
                    ->searchable()
                    ->preload(),

                Filter::make('title')
                    ->form([
                        TextInput::make('title')
                            ->placeholder('Search by title'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['title'],
                                fn(Builder $query, $title): Builder => $query->where('title', 'like', "%{$title}%")
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! empty($data['title'])) {
                            return 'Title: ' . $data['title'];
                        }

                        return null;
                    }),

                Filter::make('description')
                    ->form([
                        TextInput::make('description')
                            ->placeholder('Search by description'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['description'],
                                fn(Builder $query, $description): Builder => $query->where('description', 'like', "%{$description}%")
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! empty($data['description'])) {
                            return 'Description: ' . $data['description'];
                        }

                        return null;
                    }),

            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListCmsCapabilitiesSections::route('/'),
            'create' => Pages\CreateCmsCapabilitiesSection::route('/create'),
            'edit' => Pages\EditCmsCapabilitiesSection::route('/{record}/edit'),
        ];
    }
}
