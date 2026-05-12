<?php
namespace App\Filament\Resources\PrivacyPolicyResource\Pages;
use App\Filament\Resources\PrivacyPolicyResource;
use App\Models\PrivacyPolicy;
use Filament\Resources\Pages\ListRecords;

class ListPrivacyPolicies extends ListRecords {
    protected static string $resource = PrivacyPolicyResource::class;
    public function mount(): void {
        $record = PrivacyPolicy::firstOrCreate([], ['title_ar' => 'سياسة الخصوصية', 'title_en' => 'Privacy Policy']);
        redirect(PrivacyPolicyResource::getUrl('edit', ['record' => $record->id]));
    }
    protected function getHeaderActions(): array { return []; }
}
