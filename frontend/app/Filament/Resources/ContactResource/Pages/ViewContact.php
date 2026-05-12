<?php
namespace App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord {
    protected static string $resource = ContactResource::class;

    public function mount(int|string $record): void {
        parent::mount($record);
        // تحديد كمقروء تلقائياً عند الفتح
        if (!$this->record->is_read) {
            $this->record->update(['is_read' => true]);
        }
    }

    protected function getHeaderActions(): array {
        return [
            Actions\Action::make('toggleRead')
                ->label(fn () => $this->record->is_read ? 'تحديد كغير مقروء' : 'تحديد كمقروء')
                ->icon(fn () => $this->record->is_read ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                ->color(fn () => $this->record->is_read ? 'warning' : 'success')
                ->action(function () {
                    $this->record->update(['is_read' => !$this->record->is_read]);
                    $this->refreshFormData(['is_read']);
                }),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
