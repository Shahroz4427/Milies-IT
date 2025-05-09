<?php

namespace App\Filament\Resources\CustomWebDevSectionResource\Pages;

use App\Filament\Resources\CustomWebDevSectionResource;
use App\Models\CustomWebDevSection;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomWebDevSections extends ListRecords
{
    protected static string $resource = CustomWebDevSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
