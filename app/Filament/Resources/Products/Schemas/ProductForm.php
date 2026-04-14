<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Caramel Macchiato'),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->placeholder('25000'),

                Select::make('category')
                    ->required()
                    ->options([
                        'coffee'   => '☕ Coffee',
                        'beverage' => '🧃 Beverage',
                        'food'     => '🍔 Food',
                        'dessert'  => '🍰 Dessert',
                    ])
                    ->default('coffee'),

                Toggle::make('is_available')
                    ->label('Tersedia')
                    ->default(true)
                    ->helperText('Nonaktifkan jika produk sedang habis'),

                FileUpload::make('image_path')
                    ->label('Foto Produk')
                    ->image()
                    ->imageEditor()
                    ->directory('products')
                    ->imagePreviewHeight('250')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->placeholder('Deskripsi produk...')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
