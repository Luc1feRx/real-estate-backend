<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
                TextColumn::make('parent.name')->label('Parent Category'),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => fn($state) => (int)$state === Category::ACTIVE,
                        'danger' => fn($state) => (int)$state === Category::INACTIVE,
                    ])
                    ->formatStateUsing(fn ($state) => (int)$state === Category::ACTIVE ? 'Active' : 'Inactive'),
                TextColumn::make('created_at')->date('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->poll('5s');
    }
}
