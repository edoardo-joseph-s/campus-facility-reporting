<?php

namespace App\Filament\Admin\Resources\LaporanKinerjaResource\Pages;

use App\Filament\Admin\Resources\LaporanKinerjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaporanKinerjas extends ListRecords
{
    protected static string $resource = LaporanKinerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
