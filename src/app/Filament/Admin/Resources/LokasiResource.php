<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LokasiResource\Pages;
use App\Filament\Admin\Resources\LokasiResource\RelationManagers;
use App\Models\Lokasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LokasiResource extends Resource
{
    protected static ?string $model = Lokasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'MASTER DATA';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Lokasi';
    protected static ?string $pluralModelLabel = 'Lokasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Umum')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                $set('kode', str()->slug($state));
                            }),
                        Forms\Components\TextInput::make('kode')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('deskripsi')
                            ->maxLength(65535)
                            ->nullable()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Lokasi')
                    ->schema([
                        Forms\Components\TextInput::make('blok')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('gedung')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('lantai')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('koordinat')
                            ->maxLength(255)
                            ->placeholder('Latitude, Longitude'),
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'nama')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('aktif')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('urutan')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gedung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lantai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.nama')
                    ->label('Lokasi Induk')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListLokasis::route('/'),
            'create' => Pages\CreateLokasi::route('/create'),
            'edit' => Pages\EditLokasi::route('/{record}/edit'),
        ];
    }
}
