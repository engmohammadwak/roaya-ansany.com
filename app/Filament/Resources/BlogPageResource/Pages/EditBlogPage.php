<?php
namespace App\Filament\Resources\BlogPageResource\Pages;
use App\Filament\Resources\BlogPageResource;
use Filament\Resources\Pages\EditRecord;
class EditBlogPage extends EditRecord {
    protected static string $resource = BlogPageResource::class;
    protected function getHeaderActions(): array { return []; }
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
