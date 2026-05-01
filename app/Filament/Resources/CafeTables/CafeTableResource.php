<?php

namespace App\Filament\Resources\CafeTables;

use App\Models\CafeTable;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class CafeTableResource extends Resource
{
    protected static ?string $model = CafeTable::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;

    protected static ?string $navigationLabel = 'Meja Cafe';

    protected static UnitEnum|string|null $navigationGroup = 'Cafe Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Meja')->schema([
                TextInput::make('name')
                    ->label('Nama Meja')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Meja 1'),
                TextInput::make('capacity')
                    ->label('Kapasitas (Kursi)')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(20)
                    ->default(2),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => '✅ Tersedia',
                        'reserved'  => '📋 Direservasi',
                        'occupied'  => '🔴 Terpakai',
                    ])
                    ->default('available')
                    ->required(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Meja')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('capacity')
                    ->label('Kapasitas')
                    ->suffix(' kursi')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'reserved'  => 'warning',
                        'occupied'  => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => '✅ Tersedia',
                        'reserved'  => '📋 Direservasi',
                        'occupied'  => '🔴 Terpakai',
                        default     => $state,
                    }),
                TextColumn::make('reservations_count')
                    ->counts('reservations')
                    ->label('Reservasi')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Dibuat')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCafeTables::route('/'),
            'create' => Pages\CreateCafeTable::route('/create'),
            'edit'   => Pages\EditCafeTable::route('/{record}/edit'),
        ];
    }
}
