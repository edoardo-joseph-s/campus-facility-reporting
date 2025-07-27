<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PengumumanResource\Pages;
use App\Filament\Admin\Resources\PengumumanResource\RelationManagers;
use App\Models\Pengumuman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengumumanResource extends Resource
{
    protected static ?string $model = Pengumuman::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'MASTER DATA';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Pengumuman';
    protected static ?string $pluralModelLabel = 'Pengumuman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengumuman')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('konten')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('tipe')
                            ->required()
                            ->options([
                                'info' => 'Informasi',
                                'peringatan' => 'Peringatan',
                                'penting' => 'Penting'
                            ])
                            ->default('info'),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('pengumuman-thumbnails')
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan Waktu')
                    ->schema([
                        Forms\Components\DateTimePicker::make('tanggal_mulai')
                            ->required()
                            ->default(now()),
                        Forms\Components\DateTimePicker::make('tanggal_selesai')
                            ->nullable()
                            ->after('tanggal_mulai'),
                        Forms\Components\Toggle::make('aktif')
                            ->required()
                            ->default(true),
                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->id())
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'info' => 'info',
                        'peringatan' => 'warning',
                        'penting' => 'danger',
                    }),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
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
            'index' => Pages\ListPengumumen::route('/'),
            'create' => Pages\CreatePengumuman::route('/create'),
            'edit' => Pages\EditPengumuman::route('/{record}/edit'),
        ];
    }
}
