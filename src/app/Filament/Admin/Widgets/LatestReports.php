<?php

namespace App\Filament\Admin\Widgets;

use App\Models\SemuaLaporan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestReports extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SemuaLaporan::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nomor_laporan')
                    ->label('Nomor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'diajukan' => 'info',
                        'diproses' => 'warning',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (SemuaLaporan $record): string => route('filament.admin.resources.semua-laporans.edit', $record))
                    ->icon('heroicon-m-pencil-square')
                    ->label('Edit'),
            ]);
    }
}
