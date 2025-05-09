<?php

namespace App\Filament\Resources\SiteContactResource\Pages;

use App\Filament\Resources\SiteContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteContact extends EditRecord
{
    protected static string $resource = SiteContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
