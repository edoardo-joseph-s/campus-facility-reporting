<?php

namespace App\Filament\Admin\Resources\LaporanKinerjaResource\Pages;

use App\Filament\Admin\Resources\LaporanKinerjaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporanKinerja extends EditRecord
{
    protected static string $resource = LaporanKinerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
