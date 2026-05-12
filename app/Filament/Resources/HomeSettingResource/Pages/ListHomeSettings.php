<?php

namespace App\Filament\Resources\HomeSettingResource\Pages;

use App\Filament\Resources\HomeSettingResource;
use App\Models\HomeSetting;
use Filament\Resources\Pages\ListRecords;

class ListHomeSettings extends ListRecords
{
    protected static string $resource = HomeSettingResource::class;

    // Auto-redirect to edit the single row
    public function mount(): void
    {
        $setting = HomeSetting::instance();
        $this->redirect(HomeSettingResource::getUrl('edit', ['record' => $setting->id]));
    }
}
