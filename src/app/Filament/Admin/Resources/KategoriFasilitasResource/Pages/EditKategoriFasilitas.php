<?php

namespace App\Filament\Admin\Resources\KategoriFasilitasResource\Pages;

use App\Filament\Admin\Resources\KategoriFasilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriFasilitas extends EditRecord
{
    protected static string $resource = KategoriFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
