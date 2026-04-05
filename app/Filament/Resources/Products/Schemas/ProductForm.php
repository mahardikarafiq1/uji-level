<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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

                FileUpload::make('image_path')
                    ->label('Product Image')
                    ->image()
                    ->imageEditor()
                    ->directory('products')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->placeholder('Describe the product...')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
