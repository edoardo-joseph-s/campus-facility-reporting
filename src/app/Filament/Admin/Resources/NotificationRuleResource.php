<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NotificationRuleResource\Pages;
use App\Filament\Admin\Resources\NotificationRuleResource\RelationManagers;
use App\Models\NotificationRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotificationRuleResource extends Resource
{
    protected static ?string $model = NotificationRule::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationGroup = 'PENGATURAN SISTEM';
    protected static ?string $navigationLabel = 'Aturan Notifikasi';
    protected static ?string $modelLabel = 'Aturan Notifikasi';
    protected static ?string $pluralModelLabel = 'Aturan Notifikasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Event')
                    ->schema([
                        Forms\Components\TextInput::make('event_name')
                            ->label('Nama Event')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('event_description')
                            ->label('Deskripsi')
                            ->nullable()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan Notifikasi')
                    ->schema([
                        Forms\Components\Toggle::make('notify_reporter')
                            ->label('Kirim ke Pelapor')
                            ->helperText('Notifikasi akan dikirim ke pengguna yang membuat laporan')
                            ->default(true),
                        Forms\Components\Toggle::make('notify_admin')
                            ->label('Kirim ke Admin')
                            ->helperText('Notifikasi akan dikirim ke semua admin')
                            ->default(true),
                        Forms\Components\Toggle::make('notify_assignee')
                            ->label('Kirim ke Petugas')
                            ->helperText('Notifikasi akan dikirim ke petugas yang ditugaskan')
                            ->default(true),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Nonaktifkan untuk menghentikan notifikasi sementara')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event_name')
                    ->label('Nama Event')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('notify_reporter')
                    ->label('Ke Pelapor')
                    ->boolean(),
                Tables\Columns\IconColumn::make('notify_admin')
                    ->label('Ke Admin')
                    ->boolean(),
                Tables\Columns\IconColumn::make('notify_assignee')
                    ->label('Ke Petugas')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\IconColumn::make('notify_reporter')
                    ->boolean(),
                Tables\Columns\IconColumn::make('notify_admin')
                    ->boolean(),
                Tables\Columns\IconColumn::make('notify_assignee')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListNotificationRules::route('/'),
            'create' => Pages\CreateNotificationRule::route('/create'),
            'edit' => Pages\EditNotificationRule::route('/{record}/edit'),
        ];
    }
}
