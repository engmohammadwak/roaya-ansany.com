<?php
namespace App\Filament\Resources\BlogPageResource\Pages;
use App\Filament\Resources\BlogPageResource;
use App\Models\BlogPage;
use Filament\Resources\Pages\ListRecords;
class ListBlogPages extends ListRecords {
    protected static string $resource = BlogPageResource::class;
    public function mount(): void {
        $record = BlogPage::firstOrCreate([]);
        $this->redirect(BlogPageResource::getUrl('edit', ['record' => $record->id]));
    }
    protected function getHeaderActions(): array { return []; }
}
