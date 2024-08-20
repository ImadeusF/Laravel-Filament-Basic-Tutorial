<?php

namespace App\Filament\Resources\ArticlesResource\Pages;

use App\Filament\Resources\ArticlesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticles extends CreateRecord
{
    protected static string $resource = ArticlesResource::class;
}
