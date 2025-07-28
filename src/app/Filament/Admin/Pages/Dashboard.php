<?php

namespace App\Filament\Admin\Pages;

use App\Models\SemuaLaporan;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
class Dashboard extends BaseDashboard
{

    public function getActions(): array
    {
        return [
            Action::make('new_report')
                ->label('Buat Laporan Baru')
                ->url(route('filament.admin.resources.semua-laporans.create'))
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Admin\Widgets\StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Admin\Widgets\LatestReports::class,
        ];
    }
}
