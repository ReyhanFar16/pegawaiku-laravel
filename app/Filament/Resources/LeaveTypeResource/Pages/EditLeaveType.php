<?php

namespace App\Filament\Resources\LeaveTypeResource\Pages;

use App\Filament\Resources\LeaveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaveType extends EditRecord
{
    protected static string $resource = LeaveTypeResource::class;
    protected static ?string $title = "Ubah Jenis Cuti";
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
