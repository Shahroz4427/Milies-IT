<?php

namespace App\Filament\Resources\PortfolioSectionResource\Pages;

use App\Filament\Resources\PortfolioSectionResource;
use App\Models\PortfolioSection;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPortfolioSections extends ListRecords
{
    protected static string $resource = PortfolioSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


}
