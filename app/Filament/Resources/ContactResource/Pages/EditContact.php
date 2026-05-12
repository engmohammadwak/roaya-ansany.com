<?php
namespace App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord {
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }

    // فقط is_read يتغيّر
    protected function mutateFormDataBeforeSave(array $data): array {
        return ['is_read' => $data['is_read'] ?? false];
    }
}
