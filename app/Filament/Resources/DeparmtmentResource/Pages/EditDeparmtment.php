<?php

namespace App\Filament\Resources\DeparmtmentResource\Pages;

use App\Filament\Resources\DeparmtmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeparmtment extends EditRecord
{
    protected static string $resource = DeparmtmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
