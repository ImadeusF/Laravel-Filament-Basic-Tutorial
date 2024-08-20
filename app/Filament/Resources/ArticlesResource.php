<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticlesResource\Pages;
use App\Filament\Resources\ArticlesResource\RelationManagers;
use App\Models\Articles;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticlesResource extends Resource
{
    protected static ?string $model = Articles::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                // On masque le champ user_id et on le remplit automatiquement
                Forms\Components\Hidden::make('user_id')
                ->default(auth()->user()->id),
                //On fait en sorte que le champ category_id soit un select mais on affiche le nom pour le choix
                Forms\Components\Select::make('category_id')
                    ->relationship('categories', 'name') // dans la relation, on reprend le nom de la méthode donnée dans le modèle Articles.php et dans le select, on affiche le nom de la catégorie
                    ->searchable() // on peut rechercher dans le select
                    ->preload() // on charge toutes les catégories
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticles::route('/create'),
            'view' => Pages\ViewArticles::route('/{record}'),
            'edit' => Pages\EditArticles::route('/{record}/edit'),
        ];
    }
}
