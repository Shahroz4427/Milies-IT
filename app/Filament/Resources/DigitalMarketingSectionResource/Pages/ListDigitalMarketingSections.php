<?php

namespace App\Filament\Resources\DigitalMarketingSectionResource\Pages;

use App\Filament\Resources\DigitalMarketingSectionResource;
use App\Models\DigitalMarketingSection;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDigitalMarketingSections extends ListRecords
{
    protected static string $resource = DigitalMarketingSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
