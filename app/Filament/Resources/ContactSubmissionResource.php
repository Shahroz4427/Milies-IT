<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Filament\Resources\ContactSubmissionResource\RelationManagers;
use App\Models\ContactSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\{TextInput, Textarea, Select, DateTimePicker, Section};

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Landing Page & Description')
                    ->schema([
                        Select::make('landing_page_id')
                            ->label('Landing Page')
                            ->relationship('landingPage', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                ]),

                Section::make('Contact Info')
                    ->schema([

                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('company_email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->nullable()
                            ->maxLength(255),

                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Description')
                            ->nullable()
                            ->rows(5),
                    ])
                    ->columns(2),

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

                TextColumn::make('first_name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('company_email')
                    ->label('Email')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('company_name')
                    ->label('Company')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('landing_page_id')
                    ->label('Landing Page')
                    ->relationship('landingPage', 'title')
                    ->searchable()
                    ->preload(),

                Filter::make('created_at')
                    ->label('Submitted Date')
                    ->form([
                        DatePicker::make('submitted_from')->label('From'),
                        DatePicker::make('submitted_until')->label('To'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['submitted_from'], fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['submitted_until'], fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['submitted_from'] && $data['submitted_until']) {
                            return 'Submitted: ' . \Carbon\Carbon::parse($data['submitted_from'])->toFormattedDateString() .
                                ' to ' . \Carbon\Carbon::parse($data['submitted_until'])->toFormattedDateString();
                        }
                        if ($data['submitted_from']) {
                            return 'Submitted from ' . \Carbon\Carbon::parse($data['submitted_from'])->toFormattedDateString();
                        }
                        if ($data['submitted_until']) {
                            return 'Submitted until ' . \Carbon\Carbon::parse($data['submitted_until'])->toFormattedDateString();
                        }
                        return null;
                    }),

                Filter::make('first_name')
                    ->form([
                        TextInput::make('first_name')->placeholder('Search by first name'),
                    ])
                    ->query(
                        fn(Builder $query, array $data) => $query->when($data['first_name'], fn($q, $name) => $q->where('first_name', 'like', "%{$name}%"))
                    )
                    ->indicateUsing(
                        fn(array $data) => filled($data['first_name']) ? 'First Name: ' . $data['first_name'] : null
                    ),

                Filter::make('company_email')
                    ->form([
                        TextInput::make('company_email')->placeholder('Search by email'),
                    ])
                    ->query(
                        fn(Builder $query, array $data) => $query->when($data['company_email'], fn($q, $email) => $q->where('company_email', 'like', "%{$email}%"))
                    )
                    ->indicateUsing(
                        fn(array $data) => filled($data['company_email']) ? 'Email: ' . $data['company_email'] : null
                    ),
            ])
            ->actions([
                ViewAction::make(),
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
            'index' => Pages\ListContactSubmissions::route('/'),
            'create' => Pages\CreateContactSubmission::route('/create'),
            'edit' => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
