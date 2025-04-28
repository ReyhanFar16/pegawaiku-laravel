<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveApprovalResource\Pages;
use App\Filament\Resources\LeaveApprovalResource\RelationManagers;
use App\Models\LeaveApproval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use App\Filament\Resources\Section;

class LeaveApprovalResource extends Resource
{
    protected static ?string $model = LeaveApproval::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('leave_id')
                    ->required()
                    ->relationship("leave", "reason"),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('approver_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('notes')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('leave.reason')
                    ->label("Alasan Cuti")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('leave.user.name')
                    ->label("Nama Karyawan")
                    ->sortable(),
                Tables\Columns\TextColumn::make('leave.start_date')
                    ->label("Mulai Cuti")
                    ->sortable(),
                Tables\Columns\TextColumn::make('leave.end_date')
                    ->label("Akhir Cuti")
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'reviewing' => 'warning',
                        'published' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('approver.name')
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
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->heading("Informasi Cuti")
                    ->Schema([
                        Infolists\Components\TextEntry::make('leave.reason')
                            ->label("Alasan Cuti"),
                        Infolists\Components\TextEntry::make('email'),
                        Infolists\Components\TextEntry::make('notes')
                            ->columnSpanFull(),
                    ]),
                Actions::make([
                    Action::make("approve_leave")
                        ->requiresConfirmation()
                        ->modalHeading("Setujui Cuti")
                        ->action(function (LeaveApproval $record) {
                            $this->update([
                                "status" => "approved",
                                "approver_id" => auth()->user()->id,
                            ]);

                            Notification::make()
                                ->success()
                                ->title("Cuti berhasil disetujui")
                                ->body("Terimakasih atas kerjasama Anda")
                                ->send();
                        })
                ])

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
            'index' => Pages\ListLeaveApprovals::route('/'),
            // 'create' => Pages\CreateLeaveApproval::route('/create'),
            'view' => Pages\ViewLeaveApproval::route('/{record}'),
            // 'edit' => Pages\EditLeaveApproval::route('/{record}/edit'),
        ];
    }
}
