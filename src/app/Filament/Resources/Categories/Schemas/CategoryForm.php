<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('name')
                        ->label('Name')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('slug', Str::slug($state));
                        })
                        ->required()
                        ->maxLength(255)
                        ->minLength(3)->columnSpan(2),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->minLength(3)
                        ->columnSpan(2),
                    Select::make('parent_id')
                        ->label('Danh mục cha')
                        ->relationship(
                            name: 'parent',
                            titleAttribute: 'name'
                        )
                        ->searchable()
                        ->preload()
                        ->placeholder('— (Danh mục gốc) —')
                        ->columnSpan(2),
                    Select::make('status')
                        ->options([
                            Category::ACTIVE => 'Active',
                            Category::INACTIVE => 'Inactive',
                        ])
                        ->required()
                        ->columnSpan(2),
                    RichEditor::make('description')
                        ->columnSpan(2),
                    FileUpload::make('image')
                        ->image()                   // báo là file ảnh => có thumbnail
                        ->previewable(true)         // bật preview (mặc định là true)
                        ->openable()                // click mở ảnh
                        ->downloadable()
                        ->disk('public')            // dùng disk public
                        ->directory('categories')   // thư mục lưu
                        ->visibility('public')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->columnSpan(2),
                ])->columnSpanFull(),
            ]);
    }
}
