<?php

namespace App\Filament\Admin\Resources\TugaskanKeSayaResource\Pages;

use App\Filament\Admin\Resources\TugaskanKeSayaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTugaskanKeSaya extends EditRecord
{
    protected static string $resource = TugaskanKeSayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
