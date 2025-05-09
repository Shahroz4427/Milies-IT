<?php

namespace App\Filament\Resources\SiteLogoResource\Pages;

use App\Filament\Resources\SiteLogoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteLogo extends EditRecord
{
    protected static string $resource = SiteLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
