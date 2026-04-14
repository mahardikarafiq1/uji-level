<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('order_code')
                    ->label('Kode Order')
                    ->weight('bold')
                    ->placeholder('—'),
                TextEntry::make('customer_name')
                    ->label('Nama Customer'),
                TextEntry::make('customer_phone')
                    ->label('No. WhatsApp')
                    ->placeholder('—'),
                TextEntry::make('seat_code')
                    ->label('Meja')
                    ->badge()
                    ->placeholder('—'),
                TextEntry::make('total_amount')
                    ->label('Total')
                    ->money('IDR', locale: 'id'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed'  => 'success',
                        'processing' => 'info',
                        'cancelled'  => 'danger',
                        default      => 'warning',
                    }),
                TextEntry::make('payment_method')
                    ->label('Metode Bayar')
                    ->placeholder('—'),
                TextEntry::make('notes')
                    ->label('Catatan')
                    ->placeholder('—')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Tanggal')
                    ->dateTime(),
            ]);
    }
}
