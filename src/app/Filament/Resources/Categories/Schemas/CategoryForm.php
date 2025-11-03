<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $state, callable $set, $get) {
                        if (blank($get('slug'))) {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->required()
                    ->maxLength(255)
                    ->minLength(3),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->minLength(3),
            ]);
    }
}
