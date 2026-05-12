<?php

namespace App\Filament\Resources\TermsOfUseResource\Pages;

use App\Filament\Resources\TermsOfUseResource;
use App\Models\TermsOfUse;
use Filament\Resources\Pages\ListRecords;

class ListTermsOfUses extends ListRecords
{
    protected static string $resource = TermsOfUseResource::class;

    public function mount(): void
    {
        $record = TermsOfUse::first();

        if ($record) {
            $this->redirect(
                TermsOfUseResource::getUrl('edit', ['record' => $record->id])
            );
        } else {
            $this->redirect(
                TermsOfUseResource::getUrl('create')
            );
        }
    }
}
