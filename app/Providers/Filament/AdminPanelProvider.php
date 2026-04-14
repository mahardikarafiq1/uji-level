<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\CafeStatsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->brandName('Felize Cafe ☕')
            ->colors([
                'primary' => [
                    50  => '#fdf8f0',
                    100 => '#f5e6d3',
                    200 => '#e5d0b5',
                    300 => '#d4b896',
                    400 => '#b8916a',
                    500 => '#8b6914',
                    600 => '#6b3b1a',
                    700 => '#4b2a12',
                    800 => '#3a1f0d',
                    900 => '#2b1608',
                    950 => '#1a0d04',
                ],
                'danger'  => Color::Rose,
                'gray'    => [
                    50  => '#faf8f5',
                    100 => '#f0ebe3',
                    200 => '#e5d6c3',
                    300 => '#d8c8b5',
                    400 => '#c4a882',
                    500 => '#a08060',
                    600 => '#7a5e44',
                    700 => '#5c4633',
                    800 => '#3d2e22',
                    900 => '#2b1f17',
                    950 => '#1a110d',
                ],
                'info'    => Color::Sky,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
            ])
            ->font('Inter')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('280px')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                CafeStatsOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
