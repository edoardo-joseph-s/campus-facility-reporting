<?php

namespace App\Filament\Admin\Resources\KategoriFasilitasResource\Pages;

use App\Filament\Admin\Resources\KategoriFasilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriFasilitas extends ListRecords
{
    protected static string $resource = KategoriFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
