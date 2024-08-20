<?php

namespace App\Filament\Resources\CategoriesResource\Pages;

use App\Filament\Resources\CategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCategories extends ViewRecord
{
    protected static string $resource = CategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
