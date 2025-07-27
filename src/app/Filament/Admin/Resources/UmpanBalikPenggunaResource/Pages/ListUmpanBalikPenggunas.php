<?php

namespace App\Filament\Admin\Resources\UmpanBalikPenggunaResource\Pages;

use App\Filament\Admin\Resources\UmpanBalikPenggunaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUmpanBalikPenggunas extends ListRecords
{
    protected static string $resource = UmpanBalikPenggunaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
