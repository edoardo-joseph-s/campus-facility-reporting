<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PetaKerusakanResource\Pages;
use App\Filament\Admin\Resources\PetaKerusakanResource\RelationManagers;
use App\Models\PetaKerusakan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetaKerusakanResource extends Resource
{
    protected static ?string $model = PetaKerusakan::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'ANALITIK & LAPORAN';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lokasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Select::make('tingkat_kerusakan')
                    ->required()
                    ->options([
                        'ringan' => 'Ringan',
                        'sedang' => 'Sedang',
                        'berat' => 'Berat',
                    ]),
                Forms\Components\FileUpload::make('gambar')
                    ->image()
                    ->directory('peta-kerusakan')
                    ->nullable(),
                Forms\Components\DatePicker::make('tanggal_inspeksi')
                    ->required(),
                Forms\Components\Select::make('semua_laporan_id')
                    ->relationship('semuaLaporan', 'id')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tingkat_kerusakan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ringan' => 'success',
                        'sedang' => 'warning',
                        'berat' => 'danger',
                    }),
                Tables\Columns\ImageColumn::make('gambar'),
                Tables\Columns\TextColumn::make('tanggal_inspeksi')
                    ->date()
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
            'index' => Pages\ListPetaKerusakans::route('/'),
            'create' => Pages\CreatePetaKerusakan::route('/create'),
            'edit' => Pages\EditPetaKerusakan::route('/{record}/edit'),
        ];
    }
}
