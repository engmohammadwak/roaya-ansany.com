<?php
namespace App\Filament\Resources\DonationResource\Pages;

use App\Filament\Resources\DonationResource;
use App\Models\Donation;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListDonations extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = DonationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [\App\Filament\Widgets\DonationStatsWidget::class];
    }
}
