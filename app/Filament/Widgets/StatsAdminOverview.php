<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\Team;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
             
           
            Stat::make('Users', User::count())
            ->description('All users from the database')
            ->descriptionIcon('heroicon-m-arrow-trending-up'),
        Stat::make('Teams', Team::count())
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


// A widget is like a small box (mini tool) that shows extra information or functionality on your dashboard or resource pages.
// Think of them as quick info cards or mini-reports.

// Types of Widgets in Filament

// Stats Overview Widgets → Show simple numbers (counts, totals).

// Chart Widgets → Show graphs/charts (e.g., income per month).

// Table Widgets → Show small tables (e.g., list of recent appointments).

// Custom Widgets → You can build your own with any content.