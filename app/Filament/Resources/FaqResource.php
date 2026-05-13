<?php

namespace App\Filament\Resources;

use App\Models\Faq;
use Filament\Resources\Resource;

/**
 * مخفي — كل شيء انتقل لـ FaqCategoryResource
 */
class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static bool $shouldRegisterNavigation = false;

    public static function getPages(): array { return []; }
}
