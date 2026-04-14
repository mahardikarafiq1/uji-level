<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image_path')
                    ->label('Foto Produk')
                    ->height(250)
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('price')
                    ->money('IDR', locale: 'id'),
                TextEntry::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'coffee'   => 'warning',
                        'beverage' => 'info',
                        'food'     => 'success',
                        'dessert'  => 'danger',
                        default    => 'gray',
                    }),
                IconEntry::make('is_available')
                    ->label('Tersedia')
                    ->boolean(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
