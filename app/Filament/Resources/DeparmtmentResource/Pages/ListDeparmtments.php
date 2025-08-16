<?php

namespace App\Filament\Resources\DeparmtmentResource\Pages;

use App\Filament\Resources\DeparmtmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeparmtments extends ListRecords
{
    protected static string $resource = DeparmtmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
