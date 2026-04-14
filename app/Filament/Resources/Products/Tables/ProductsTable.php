<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Menu&background=4b2a12&color=fff'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'coffee'   => 'warning',
                        'beverage' => 'info',
                        'food'     => 'success',
                        'dessert'  => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'coffee'   => '☕ Coffee',
                        'beverage' => '🧃 Beverage',
                        'food'     => '🍔 Food',
                        'dessert'  => '🍰 Dessert',
                        default    => $state,
                    }),

                TextColumn::make('price')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                IconColumn::make('is_available')
                    ->label('Tersedia')
                    ->boolean(),

                TextColumn::make('description')
                    ->limit(50)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'coffee'   => '☕ Coffee',
                        'beverage' => '🧃 Beverage',
                        'food'     => '🍔 Food',
                        'dessert'  => '🍰 Dessert',
                    ]),
                TernaryFilter::make('is_available')
                    ->label('Tersedia'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
