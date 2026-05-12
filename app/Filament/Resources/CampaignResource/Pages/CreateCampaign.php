<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCampaign extends CreateRecord
{
    protected static string $resource = CampaignResource::class;

    // بعد الإضافة يرجع لقائمة الحملات
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
