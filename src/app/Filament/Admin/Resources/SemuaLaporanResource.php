<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SemuaLaporanResource\Pages;
use App\Filament\Admin\Resources\SemuaLaporanResource\RelationManagers;
use App\Models\SemuaLaporan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SemuaLaporanResource extends Resource
{
    protected static ?string $model = SemuaLaporan::class;

    protected static ?string $navigationGroup = 'ANALITIK & LAPORAN';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    
    protected static ?string $modelLabel = 'Semua Laporan';
    protected static ?string $pluralModelLabel = 'Semua Laporan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Laporan')
                            ->schema([
                                Forms\Components\TextInput::make('nomor_laporan')
                                    ->label('Nomor Laporan')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->visible(fn ($record) => $record !== null),
                                Forms\Components\TextInput::make('judul')
                                    ->label('Judul')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('deskripsi')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('lokasi_id')
                                    ->label('Lokasi')
                                    ->relationship('lokasi', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Select::make('kategori_id')
                                    ->label('Kategori')
                                    ->relationship('kategori', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Section::make('Status dan Prioritas')
                            ->schema([
                                Forms\Components\Select::make('prioritas')
                                    ->label('Prioritas')
                                    ->options([
                                        'rendah' => 'Rendah',
                                        'sedang' => 'Sedang',
                                        'tinggi' => 'Tinggi',
                                        'urgent' => 'Urgent'
                                    ])
                                    ->default('sedang')
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'diajukan' => 'Diajukan',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai',
                                        'ditolak' => 'Ditolak'
                                    ])
                                    ->default('draft')
                                    ->required(),
                                Forms\Components\Textarea::make('catatan')
                                    ->label('Catatan')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ])->columns(2)
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Tanggal')
                            ->schema([
                                Forms\Components\DatePicker::make('tanggal_laporan')
                                    ->label('Tanggal Laporan')
                                    ->required()
                                    ->default(now()),
                                Forms\Components\DatePicker::make('target_penyelesaian')
                                    ->label('Target Penyelesaian')
                                    ->nullable()
                                    ->after('tanggal_laporan'),
                                Forms\Components\DatePicker::make('tanggal_selesai')
                                    ->label('Tanggal Selesai')
                                    ->nullable()
                                    ->after('tanggal_laporan')
                                    ->visible(fn ($get) => $get('status') === 'selesai'),
                            ]),
                        Forms\Components\Section::make('Lampiran')
                            ->schema([
                                Forms\Components\FileUpload::make('lampiran')
                                    ->label('Lampiran')
                                    ->multiple()
                                    ->directory('laporan-kinerja')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->id())
                    ])->columnSpan(['lg' => 1])
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_laporan')
                    ->label('Nomor Laporan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('lokasi.nama')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prioritas')
                    ->label('Prioritas')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'rendah' => 'gray',
                        'sedang' => 'warning',
                        'tinggi' => 'danger',
                        'urgent' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'diajukan' => 'info',
                        'diproses' => 'warning',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_laporan')
                    ->label('Tanggal Laporan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_penyelesaian')
                    ->label('Target Penyelesaian')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'diajukan' => 'Diajukan',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak'
                    ]),
                Tables\Filters\SelectFilter::make('prioritas')
                    ->options([
                        'rendah' => 'Rendah',
                        'sedang' => 'Sedang',
                        'tinggi' => 'Tinggi',
                        'urgent' => 'Urgent'
                    ]),
                Tables\Filters\SelectFilter::make('lokasi')
                    ->relationship('lokasi', 'nama'),
                Tables\Filters\SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSemuaLaporans::route('/'),
            'create' => Pages\CreateSemuaLaporan::route('/create'),
            'edit' => Pages\EditSemuaLaporan::route('/{record}/edit'),
        ];
    }
}
