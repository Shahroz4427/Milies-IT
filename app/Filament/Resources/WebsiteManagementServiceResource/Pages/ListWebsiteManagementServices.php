<?php

namespace App\Filament\Resources\WebsiteManagementServiceResource\Pages;

use App\Filament\Resources\WebsiteManagementServiceResource;
use App\Models\WebsiteManagementService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebsiteManagementServices extends ListRecords
{
    protected static string $resource = WebsiteManagementServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
