<?php

namespace App\Filament\Resources\CustomWebDevSectionResource\Pages;

use App\Filament\Resources\CustomWebDevSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomWebDevSection extends EditRecord
{
    protected static string $resource = CustomWebDevSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
