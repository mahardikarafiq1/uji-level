<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Detail Item Pesanan';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('product.image_path')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=P&background=4b2a12&color=fff'),
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->weight('bold'),
                TextColumn::make('quantity')
                    ->label('Qty'),
                TextColumn::make('unit_price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id'),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR', locale: 'id')
                    ->weight('bold'),
            ]);
    }
}
