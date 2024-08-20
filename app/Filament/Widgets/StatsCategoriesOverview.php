<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Categories;

class StatsCategoriesOverview extends BaseWidget
{

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Categories', Categories::query()->count())
                ->description('Toutes les catégories')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];

    }
}
