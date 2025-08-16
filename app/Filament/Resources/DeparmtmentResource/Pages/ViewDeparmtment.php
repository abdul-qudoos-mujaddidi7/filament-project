<?php

namespace App\Filament\Resources\DeparmtmentResource\Pages;

use App\Filament\Resources\DeparmtmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDeparmtment extends ViewRecord
{
    protected static string $resource = DeparmtmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
