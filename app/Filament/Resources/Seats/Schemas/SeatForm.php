<?php

namespace App\Filament\Resources\Seats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SeatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('seat_code')
                    ->required(),
                TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                TextInput::make('position'),
            ]);
    }
}
