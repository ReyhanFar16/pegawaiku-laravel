<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveTypeResource\Pages;
use App\Filament\Resources\LeaveTypeResource\RelationManagers;
use App\Models\LeaveType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveTypeResource extends Resource
{
    protected static ?string $model = LeaveType::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationLabel = 'Jenis Cuti';
    protected static ?string $breadcrumb = 'Jenis Cuti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Jenis Cuti')
                    ->placeholder('Cuti Tahunan')
                    ->helperText("Masukkan jenis cuti yang diinginkan")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('max_days')
                    ->label('Maksimal Hari')
                    ->helperText("Masukkan maksimal hari cuti")
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Jenis Cuti')
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_days')
                    ->label('Maksimal dalam setahun')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLeaveTypes::route('/'),
            'create' => Pages\CreateLeaveType::route('/create'),
            'edit' => Pages\EditLeaveType::route('/{record}/edit'),
        ];
    }
}


