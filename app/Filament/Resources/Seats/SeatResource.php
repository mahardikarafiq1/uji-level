<?php

namespace App\Filament\Resources\Seats;

use App\Filament\Resources\Seats\Pages\CreateSeat;
use App\Filament\Resources\Seats\Pages\EditSeat;
use App\Filament\Resources\Seats\Pages\ListSeats;
use App\Filament\Resources\Seats\Pages\ViewSeat;
use App\Filament\Resources\Seats\Schemas\SeatForm;
use App\Filament\Resources\Seats\Schemas\SeatInfolist;
use App\Filament\Resources\Seats\Tables\SeatsTable;
use App\Models\Seat;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SeatResource extends Resource
{
    protected static ?string $model = Seat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'Seat Layout';

    protected static UnitEnum|string|null $navigationGroup = 'Cafe Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'seat_code';

    public static function form(Schema $schema): Schema
    {
        return SeatForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SeatInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSeats::route('/'),
            'create' => CreateSeat::route('/create'),
            'view'   => ViewSeat::route('/{record}'),
            'edit'   => EditSeat::route('/{record}/edit'),
        ];
    }
}
