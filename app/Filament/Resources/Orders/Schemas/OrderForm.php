<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Linked User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable()
                    ->placeholder('Guest order (no account)'),

                TextInput::make('customer_name')
                    ->placeholder('Customer name')
                    ->maxLength(255),

                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),

                Select::make('status')
                    ->required()
                    ->options([
                        'pending'    => '🟡 Pending',
                        'processing' => '🔵 Processing',
                        'completed'  => '✅ Completed',
                        'cancelled'  => '🔴 Cancelled',
                    ])
                    ->default('pending'),
            ]);
    }
}
