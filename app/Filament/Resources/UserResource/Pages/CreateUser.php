<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\UserResource\Pages\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function beforeCreate()
    {


        if (!$this->data["password"]) {
            Notification::make()
                ->warning()
                ->title('Password tidak boleh kosong')
                ->body('Mohon isikan password terlebih dahulu')
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}
