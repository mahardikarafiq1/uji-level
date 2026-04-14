<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_code')
                    ->label('Kode')
                    ->searchable()
                    ->weight('bold')
                    ->copyable()
                    ->placeholder('—'),

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->weight('bold')
                    ->placeholder('Guest'),

                TextColumn::make('customer_phone')
                    ->label('WhatsApp')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('seat_code')
                    ->label('Meja')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Bayar')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'whatsapp' => 'success',
                        'qris'     => 'info',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'whatsapp' => '💬 WhatsApp',
                        'qris'     => '📱 QRIS',
                        default    => '—',
                    }),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed'  => 'success',
                        'processing' => 'info',
                        'cancelled'  => 'danger',
                        default      => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'    => '🟡 Pending',
                        'processing' => '🔵 Diproses',
                        'completed'  => '✅ Selesai',
                        'cancelled'  => '🔴 Batal',
                        default      => $state,
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Tanggal'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'processing' => 'Diproses',
                        'completed'  => 'Selesai',
                        'cancelled'  => 'Batal',
                    ]),
                SelectFilter::make('payment_method')
                    ->label('Metode Bayar')
                    ->options([
                        'whatsapp' => 'WhatsApp',
                        'qris'     => 'QRIS',
                    ]),
            ])
            ->recordActions([
                Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalDescription('Tandai pesanan ini sebagai sudah dibayar dan selesai?')
                    ->visible(fn ($record) => $record->status === 'pending' || $record->status === 'processing')
                    ->action(fn ($record) => $record->update(['status' => 'completed'])),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
