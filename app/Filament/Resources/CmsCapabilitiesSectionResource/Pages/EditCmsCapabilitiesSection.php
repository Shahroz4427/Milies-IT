<?php

namespace App\Filament\Resources\CmsCapabilitiesSectionResource\Pages;

use App\Filament\Resources\CmsCapabilitiesSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCmsCapabilitiesSection extends EditRecord
{
    protected static string $resource = CmsCapabilitiesSectionResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
