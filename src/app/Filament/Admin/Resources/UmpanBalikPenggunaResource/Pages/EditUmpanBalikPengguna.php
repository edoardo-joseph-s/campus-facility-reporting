<?php

namespace App\Filament\Admin\Resources\UmpanBalikPenggunaResource\Pages;

use App\Filament\Admin\Resources\UmpanBalikPenggunaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUmpanBalikPengguna extends EditRecord
{
    protected static string $resource = UmpanBalikPenggunaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
