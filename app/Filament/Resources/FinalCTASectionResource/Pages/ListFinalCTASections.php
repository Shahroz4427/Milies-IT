<?php

namespace App\Filament\Resources\FinalCTASectionResource\Pages;

use App\Filament\Resources\FinalCTASectionResource;
use App\Models\FinalCTASection;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinalCTASections extends ListRecords
{
    protected static string $resource = FinalCTASectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
