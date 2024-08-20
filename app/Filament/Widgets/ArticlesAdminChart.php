<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Articles;

class ArticlesAdminChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Articles Graphique';

    protected function getData(): array
    {
       {
        $data = Trend::model(Articles::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Articles',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    }
    protected function getType(): string
    {
        return 'bar';
    }
}
