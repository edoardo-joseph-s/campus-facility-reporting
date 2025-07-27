<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TugaskanKeSayaResource\Pages;
use App\Models\SemuaLaporan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TugaskanKeSayaResource extends Resource
{
    protected static ?string $model = SemuaLaporan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Tugaskan Ke Saya';

    protected static ?string $slug = 'laporan-ditugaskan';

    protected static ?string $navigationGroup = 'MANAJEMEN LAPORAN';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        // Pastikan model Anda memiliki kolom 'ditugaskan_kepada_id'
        // atau ganti dengan nama kolom yang benar.
        return parent::getEloquentQuery()->where('ditugaskan_kepada_id', Auth::id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        // Anda bisa menggunakan form yang sama dengan SemuaLaporanResource jika diperlukan
        return $form
            ->schema([
                // Definisikan form fields di sini jika perlu untuk view
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('judul')->searchable(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('created_at')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Mungkin Anda ingin menambahkan action untuk mengubah status
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        // Sesuaikan dengan nama file yang digenerate oleh artisan
        return [
            'index' => Pages\ListTugaskanKeSayas::route('/'),
        ];
    }
}
