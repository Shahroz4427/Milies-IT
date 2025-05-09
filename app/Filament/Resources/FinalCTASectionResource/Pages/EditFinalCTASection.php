<?php

namespace App\Filament\Resources\FinalCTASectionResource\Pages;

use App\Filament\Resources\FinalCTASectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinalCTASection extends EditRecord
{
    protected static string $resource = FinalCTASectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
