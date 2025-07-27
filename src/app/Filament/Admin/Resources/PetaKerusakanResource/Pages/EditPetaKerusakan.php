<?php

namespace App\Filament\Admin\Resources\PetaKerusakanResource\Pages;

use App\Filament\Admin\Resources\PetaKerusakanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPetaKerusakan extends EditRecord
{
    protected static string $resource = PetaKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
