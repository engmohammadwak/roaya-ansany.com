<?php
namespace App\Filament\Resources\ContactPageResource\Pages;

use App\Filament\Resources\ContactPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactPage extends EditRecord
{
    protected static string $resource = ContactPageResource::class;

    protected function getHeaderActions(): array {
        return [];
    }

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
