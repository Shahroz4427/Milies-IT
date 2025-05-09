<?php

namespace App\Filament\Resources\WebsiteManagementServiceResource\Pages;

use App\Filament\Resources\WebsiteManagementServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebsiteManagementService extends EditRecord
{
    protected static string $resource = WebsiteManagementServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
