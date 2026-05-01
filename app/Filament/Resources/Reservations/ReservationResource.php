<?php

namespace App\Filament\Resources\Reservations;

use App\Models\Reservation;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Reservasi';

    protected static UnitEnum|string|null $navigationGroup = 'Cafe Management';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Reservasi')->schema([
                Select::make('user_id')
                    ->label('Pelanggan')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('cafe_table_id')
                    ->label('Meja')
                    ->relationship('cafeTable', 'name')
                    ->required(),
                DatePicker::make('reservation_date')
                    ->label('Tanggal')
                    ->required(),
                TimePicker::make('reservation_time')
                    ->label('Waktu')
                    ->required(),
                TextInput::make('guest_count')
                    ->label('Jumlah Tamu')
                    ->numeric()
                    ->minValue(1)
                    ->default(2)
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending'   => '🟡 Menunggu',
                        'confirmed' => '✅ Dikonfirmasi',
                        'rejected'  => '🔴 Ditolak',
                        'completed' => '🏁 Selesai',
                    ])
                    ->default('pending')
                    ->required(),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->maxLength(500)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('cafeTable.name')
                    ->label('Meja')
                    ->badge()
                    ->color('info'),
                TextColumn::make('reservation_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('reservation_time')
                    ->label('Waktu')
                    ->time('H:i'),
                TextColumn::make('guest_count')
                    ->label('Tamu')
                    ->suffix(' orang'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending'   => 'warning',
                        'rejected'  => 'danger',
                        'completed' => 'info',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'   => '🟡 Menunggu',
                        'confirmed' => '✅ Dikonfirmasi',
                        'rejected'  => '🔴 Ditolak',
                        'completed' => '🏁 Selesai',
                        default     => $state,
                    }),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Dibuat'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'rejected'  => 'Ditolak',
                        'completed' => 'Selesai',
                    ]),
            ])
            ->recordActions([
                Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Reservasi')
                    ->modalDescription('Setujui reservasi ini?')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(fn ($record) => $record->update(['status' => 'confirmed'])),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Reservasi')
                    ->modalDescription('Tolak reservasi ini?')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(fn ($record) => $record->update(['status' => 'rejected'])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('reservation_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit'   => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
