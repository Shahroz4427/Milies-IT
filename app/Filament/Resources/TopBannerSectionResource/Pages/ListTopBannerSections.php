<?php

namespace App\Filament\Resources\TopBannerSectionResource\Pages;

use App\Filament\Resources\TopBannerSectionResource;
use App\Models\TopBannerSection;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopBannerSections extends ListRecords
{
    protected static string $resource = TopBannerSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
