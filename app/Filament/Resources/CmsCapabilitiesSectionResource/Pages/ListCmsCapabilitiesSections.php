<?php

namespace App\Filament\Resources\CmsCapabilitiesSectionResource\Pages;

use App\Filament\Resources\CmsCapabilitiesSectionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListCmsCapabilitiesSections extends ListRecords
{
    protected static string $resource = CmsCapabilitiesSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
