<?php
namespace App\Filament\Resources\ContactPageResource\Pages;

use App\Filament\Resources\ContactPageResource;
use App\Models\ContactPage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactPages extends ListRecords
{
    protected static string $resource = ContactPageResource::class;

    public function mount(): void
    {
        // auto-redirect to edit the single record
        $record = ContactPage::firstOrCreate([]);
        redirect(ContactPageResource::getUrl('edit', ['record' => $record->id]));
    }

    protected function getHeaderActions(): array {
        return [];
    }
}
