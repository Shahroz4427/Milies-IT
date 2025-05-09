<?php

namespace App\Filament\Resources\FinalCTASectionResource\Pages;

use App\Filament\Resources\FinalCTASectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFinalCTASection extends CreateRecord
{
    protected static string $resource = FinalCTASectionResource::class;

    public function getBreadcrumb(): string
    {
        return 'null';
    }

    // Remove breadcrumb trail on the left
    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
