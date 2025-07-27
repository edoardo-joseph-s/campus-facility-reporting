<?php

namespace App\Filament\Admin\Resources\TugaskanKeSayaResource\Pages;

use App\Filament\Admin\Resources\TugaskanKeSayaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugaskanKeSayas extends ListRecords
{
    protected static string $resource = TugaskanKeSayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
