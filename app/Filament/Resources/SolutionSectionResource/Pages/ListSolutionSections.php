<?php

namespace App\Filament\Resources\SolutionSectionResource\Pages;

use App\Filament\Resources\SolutionSectionResource;
use App\Models\SolutionSection;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSolutionSections extends ListRecords
{
    protected static string $resource = SolutionSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
