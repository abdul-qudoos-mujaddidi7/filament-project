<?php

namespace App\Filament\App\Widgets;

use App\Models\Deparmtment;
use App\Models\Employee;
use App\Models\Team;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAppOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', Team::find(Filament::getTenant())->members()->count())
            ->description('All users from the database')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
        Stat::make('Department', Deparmtment::query()->whereBelongsTo(Filament::getTenant())->count())
            ->description('All teams from the database')
            ->descriptionIcon('heroicon-m-arrow-trending-down'),
        Stat::make('Employees', Employee::count())
            ->description('All Employess from the database')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Unique views', '192.1k')
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }
}
