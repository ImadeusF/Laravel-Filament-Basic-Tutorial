<?php

namespace App\Filament\Resources\ArticlesResource\Pages;

use App\Filament\Resources\ArticlesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArticles extends ViewRecord
{
    protected static string $resource = ArticlesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
