<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_code')
                    ->label('Kode Order')
                    ->disabled()
                    ->dehydrated()
                    ->placeholder('Auto-generated'),

                TextInput::make('customer_name')
                    ->label('Nama Customer')
                    ->placeholder('Nama customer')
                    ->maxLength(255),

                TextInput::make('customer_phone')
                    ->label('No. WhatsApp')
                    ->placeholder('6281234567890')
                    ->tel(),

                TextInput::make('total_amount')
                    ->label('Total')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),

                Select::make('status')
                    ->required()
                    ->options([
                        'pending'    => '🟡 Menunggu Pembayaran',
                        'processing' => '🔵 Diproses',
                        'completed'  => '✅ Selesai',
                        'cancelled'  => '🔴 Dibatalkan',
                    ])
                    ->default('pending'),

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'whatsapp' => '💬 WhatsApp',
                        'qris'     => '📱 QRIS',
                    ])
                    ->placeholder('Belum dipilih'),

                TextInput::make('seat_code')
                    ->label('Meja / Seat')
                    ->placeholder('e.g. A1, B2')
                    ->helperText('Kode meja yang di-booking'),

                Select::make('user_id')
                    ->label('Linked User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable()
                    ->placeholder('Guest (tanpa akun)'),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->placeholder('Catatan tambahan...')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }
}
