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
                                    ->disabled()
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('deskripsi')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->disabled()
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('lokasi_id')
                                    ->label('Lokasi')
                                    ->relationship('lokasi', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Select::make('kategori_id')
                                    ->label('Kategori')
                                    ->relationship('kategori', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
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
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai',
                                    ])
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
                                    ->disabled()
                                    ->required(),
                                Forms\Components\DatePicker::make('target_penyelesaian')
                                    ->label('Target Penyelesaian')
                                    ->disabled()
                                    ->nullable(),
                                Forms\Components\DatePicker::make('tanggal_selesai')
                                    ->label('Tanggal Selesai')
                                    ->nullable()
                                    ->visible(fn ($get) => $get('status') === 'selesai')
                                    ->after('tanggal_laporan'),
                            ]),
                        Forms\Components\Section::make('Lampiran')
                            ->schema([
                                Forms\Components\FileUpload::make('lampiran')
                                    ->label('Lampiran')
                                    ->multiple()
                                    ->directory('laporan-kinerja')
                                    ->preserveFilenames()
                                    ->disabled()
                                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                                    ->columnSpanFull(),
                            ]),
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
                        'diproses' => 'warning',
                        'selesai' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_penyelesaian')
                    ->label('Target Penyelesaian')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTugaskanKeSayas::route('/'),
            'view' => Pages\ViewTugaskanKeSaya::route('/{record}'),
            'edit' => Pages\EditTugaskanKeSaya::route('/{record}/edit'),
        ];
    }
}
