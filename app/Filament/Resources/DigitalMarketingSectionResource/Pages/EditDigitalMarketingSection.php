<?php

namespace App\Filament\Resources\DigitalMarketingSectionResource\Pages;

use App\Filament\Resources\DigitalMarketingSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDigitalMarketingSection extends EditRecord
{
    protected static string $resource = DigitalMarketingSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
