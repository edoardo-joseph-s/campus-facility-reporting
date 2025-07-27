<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KategoriFasilitasResource\Pages;
use App\Filament\Admin\Resources\KategoriFasilitasResource\RelationManagers;
use App\Models\KategoriFasilitas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriFasilitasResource extends Resource
{
    protected static ?string $model = KategoriFasilitas::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'MASTER DATA';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Kategori Fasilitas';
    protected static ?string $pluralModelLabel = 'Kategori Fasilitas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
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
                        Forms\Components\TextInput::make('ikon')
                            ->helperText('Masukkan nama ikon Heroicon (contoh: academic-cap)')
                            ->nullable(),
                        Forms\Components\Toggle::make('aktif')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('urutan')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2)
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
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListKategoriFasilitas::route('/'),
            'create' => Pages\CreateKategoriFasilitas::route('/create'),
            'edit' => Pages\EditKategoriFasilitas::route('/{record}/edit'),
        ];
    }
}
