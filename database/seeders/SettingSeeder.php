<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'Your Company Name',
                'type' => 'text',
                'description' => 'Name of the company',
            ],
            [
                'key' => 'company_address',
                'value' => 'Company Address, City, Tanzania',
                'type' => 'text',
                'description' => 'Physical address of the company',
            ],
            [
                'key' => 'usd_exchange_rate',
                'value' => '2500',
                'type' => 'number',
                'description' => 'USD Exchange Rate to TZS for salary calculations',
            ],
            [
                'key' => 'company_logo',
                'value' => '',
                'type' => 'file',
                'description' => 'Company logo image',
            ],
            [
                'key' => 'hr_finance_signature',
                'value' => '',
                'type' => 'file',
                'description' => 'HR/Finance signature image',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'description' => $setting['description'],
                ]
            );
        }
    }
}
