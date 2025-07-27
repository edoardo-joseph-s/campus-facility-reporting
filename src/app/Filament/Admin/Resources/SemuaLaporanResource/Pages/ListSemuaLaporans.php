<?php

namespace App\Filament\Admin\Resources\SemuaLaporanResource\Pages;

use App\Filament\Admin\Resources\SemuaLaporanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSemuaLaporans extends ListRecords
{
    protected static string $resource = SemuaLaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
