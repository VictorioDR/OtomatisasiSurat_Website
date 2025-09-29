<?php

namespace App\Providers\Filament;

// IMPORT DASHBOARD KUSTOM KITA DI SINI
use App\Filament\Pages\Dashboard;
use App\Settings\GeneralSettings;
use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;
// Kita hapus 'use' widget dari sini karena sudah diatur di Dashboard.php

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors(['primary' => Color::Amber])
            ->brandName(fn () => app(GeneralSettings::class)->site_name ?? 'Surat Otomatis')
            ->brandLogo(fn () =>
            app(GeneralSettings::class)->site_logo ? Storage::url(app(GeneralSettings::class)->site_logo) : null
            )
            ->favicon(asset('favicon.png')) // Pastikan Anda punya file ini di public/
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')

            // 1. MEMASTIKAN DASHBOARD KUSTOM KITA YANG DIGUNAKAN
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')

            // 2. MENGOSONGKAN WIDGETS DI SINI. PENGATURAN PINDAH KE DASHBOARD.PHP
            ->widgets([])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
