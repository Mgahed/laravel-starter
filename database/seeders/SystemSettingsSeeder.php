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
            'company_name' => 'Darezini Naturdarme',
            'general_manager' => 'Darezini Mohamad',
            'health_approval_number' => 'DE NW20176 EG',
            'full_address' => 'Industrie Str. 23, 32825 Blomberg, Deutschland',
            'landline' => '+4952354750547',
            'mobile' => '+491789208986',
            'whatsapp_enabled' => true,
            'website' => 'DAREZINI.COM',
            'tax_id' => '313/5064/3253',
            'vat_no' => 'DE 325100294',
            'eori_no' => 'DE361415158134250',
        ]);
    }
}

