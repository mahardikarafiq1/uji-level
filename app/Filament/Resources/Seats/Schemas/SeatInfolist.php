<?php

namespace App\Filament\Resources\Seats\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SeatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('seat_code'),
                TextEntry::make('capacity')
                    ->numeric(),
                TextEntry::make('position')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
