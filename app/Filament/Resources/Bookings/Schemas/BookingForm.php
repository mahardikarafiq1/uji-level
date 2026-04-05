<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Full name'),

                TextInput::make('phone_number')
                    ->tel()
                    ->placeholder('+62 xxx xxxx xxxx'),

                DatePicker::make('date')
                    ->required()
                    ->minDate(now()),

                TimePicker::make('time')
                    ->required()
                    ->seconds(false),

                TextInput::make('party_size')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(20)
                    ->default(1)
                    ->suffix('pax'),

                Select::make('status')
                    ->required()
                    ->options([
                        'reserved'  => '🟡 Reserved',
                        'confirmed' => '🟢 Confirmed',
                        'cancelled' => '🔴 Cancelled',
                        'completed' => '✅ Completed',
                    ])
                    ->default('reserved'),
            ]);
    }
}
