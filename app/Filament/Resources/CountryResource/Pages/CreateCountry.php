<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;

    protected function getCreatedNotificationTitle(): string|null{
        return "Country Created Successfully!";
    }
    
    protected function getCreatedNotification(): \Filament\Notifications\Notification|null
    {
        return Notification::make()
        ->success()
        ->title("Country Created!")
        ->body("Country Created Successfully.");
    }
}
