<?php

namespace App\Filament\Resources\TopBannerSectionResource\Pages;

use App\Filament\Resources\TopBannerSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTopBannerSection extends EditRecord
{
    protected static string $resource = TopBannerSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
