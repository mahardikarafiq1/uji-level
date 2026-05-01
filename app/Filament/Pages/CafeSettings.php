<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class CafeSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.cafe-settings';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?string $title = 'Pengaturan Cafe';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 99;

    public ?string $whatsapp_number = '';
    public ?string $qris_image = '';

    public function mount(): void
    {
        $this->whatsapp_number = Setting::getValue('whatsapp_number', '');
        $this->qris_image = Setting::getValue('qris_image', '');
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('WhatsApp')
                    ->description('Nomor WhatsApp untuk menerima pesanan dari customer.')
                    ->schema([
                        TextInput::make('whatsapp_number')
                            ->label('Nomor WhatsApp')
                            ->placeholder('6281234567890')
                            ->helperText('Format internasional tanpa +, contoh: 6281234567890')
                            ->tel()
                            ->nullable(),
                    ]),

                Section::make('QRIS')
                    ->description('Upload gambar QRIS untuk pembayaran.')
                    ->schema([
                        FileUpload::make('qris_image')
                            ->label('Gambar QRIS')
                            ->image()
                            ->disk('public')
                            ->directory('settings')
                            ->helperText('Upload gambar QR Code QRIS Anda (jika kosong, qris disembunyikan)')
                            ->nullable(),
                    ]),
            ]);
    }

    public function save(): void
    {
        Setting::setValue('whatsapp_number', $this->whatsapp_number ?? '');
        Setting::setValue('qris_image', $this->qris_image ?? '');

        Notification::make()
            ->title('Pengaturan berhasil disimpan!')
            ->success()
            ->send();
    }
}
