<?php

namespace App\Filament\Resources\HomeSettingResource\Pages;

use App\Filament\Resources\HomeSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditHomeSetting extends EditRecord
{
    protected static string $resource = HomeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم الحفظ ✅')
            ->body('تم تحديث إعدادات الصفحة الرئيسية بنجاح.');
    }
}
