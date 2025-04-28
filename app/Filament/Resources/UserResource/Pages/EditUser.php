<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (!$data["password"]) {
            // Jika password kosong, gunakan password yang sudah ada
            $data["password"] = $record->password;
            $record->update($data);
        } else {
            // Jika password diisi, gunakan yang baru
            $record->update($data);
        }

        return $record;
    }
}