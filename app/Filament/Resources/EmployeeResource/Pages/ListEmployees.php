<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
     

        return [
            'All' => Tab::make()
                ->badge(fn () => Employee::count()),

            'This Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->where('hire_date', '>=', now()->subWeek())
                )
                ->badge(fn () =>
                    Employee::whereDate('hire_date', '>=', now()->subWeek())->count()
                ),

            'This Month' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->whereDate('hire_date', '>=', now()->subMonth())
                )
                ->badge(fn () =>
                    Employee::whereDate('hire_date', '>=', now()->subMonth())->count()
                ),

            'This Year' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->whereDate('hire_date', '>=', now()->subYear())
                )
                ->badge(fn () =>
                    Employee::whereDate('hire_date', '>=',  now()->subYear())->count()
                ),
        ];
    }
}
