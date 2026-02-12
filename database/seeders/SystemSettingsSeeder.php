<?php

namespace Mgahed\LaravelStarter\Database\Seeders;

use Illuminate\Database\Seeder;
use Mgahed\LaravelStarter\Models\Admin\Settings\SystemSetting;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::firstOrCreate([], [
            'company_name' => 'Mgahed',
            'general_manager' => 'Abdelrhman Mgahed',
            'health_approval_number' => 'EG',
            'full_address' => 'Egypt',
            'landline' => '+201228954237',
            'mobile' => '+201228954237',
            'whatsapp_enabled' => true,
            'website' => 'https://mgahed.com',
            'tax_id' => '3',
            'vat_no' => 'EG',
            'eori_no' => 'EG',
        ]);
    }
}

