<?php

namespace App\Filament\Admin\Widgets;

use App\Models\SemuaLaporan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Laporan', function () {
                    try {
                        return SemuaLaporan::count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                })
                ->description('Semua laporan yang ada')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),

            Stat::make('Laporan Diproses', function () {
                    try {
                        return SemuaLaporan::where('status', 'diproses')->count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                })
                ->description('Laporan sedang ditangani')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->chart([2, 4, 6, 8, 10, 12, 14])
                ->color('warning'),

            Stat::make('Laporan Selesai', function () {
                    try {
                        return SemuaLaporan::where('status', 'selesai')->count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                })
                ->description('Laporan telah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart([15, 12, 10, 8, 6, 4, 2])
                ->color('success'),
        ];
    }
}
