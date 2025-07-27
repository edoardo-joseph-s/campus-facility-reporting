<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UmpanBalikPenggunaResource\Pages;
use App\Filament\Admin\Resources\UmpanBalikPenggunaResource\RelationManagers;
use App\Models\UmpanBalikPengguna;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UmpanBalikPenggunaResource extends Resource
{
    protected static ?string $model = UmpanBalikPengguna::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'ANALITIK & LAPORAN';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Umpan Balik';
    protected static ?string $pluralModelLabel = 'Umpan Balik Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Select::make('kategori')
                    ->required()
                    ->options([
                        'saran' => 'Saran',
                        'keluhan' => 'Keluhan',
                        'pujian' => 'Pujian',
                        'lainnya' => 'Lainnya',
                    ]),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'baru' => 'Baru',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('baru'),
                Forms\Components\Textarea::make('tanggapan')
                    ->nullable()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Pengguna'),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'saran' => 'info',
                        'keluhan' => 'warning',
                        'pujian' => 'success',
                        'lainnya' => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'baru' => 'gray',
                        'diproses' => 'warning',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat'),
                Tables\Columns\TextColumn::make('tanggal_tanggapan')
                    ->dateTime()
                    ->sortable()
                    ->label('Ditanggapi')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUmpanBalikPenggunas::route('/'),
            'create' => Pages\CreateUmpanBalikPengguna::route('/create'),
            'edit' => Pages\EditUmpanBalikPengguna::route('/{record}/edit'),
        ];
    }
}
