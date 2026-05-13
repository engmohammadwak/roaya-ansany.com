<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The settings table is key-value, no schema change needed.
        // Keys contact_phone_2, contact_phone_3,
        //       contact_email_2, contact_email_3,
        //       whatsapp_number_2, whatsapp_number_3
        // will be stored automatically via Setting::set().
        // This migration exists only as a marker.
    }

    public function down(): void {}
};
