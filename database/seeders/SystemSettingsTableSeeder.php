<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SystemSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::create([
            'companyName' => 'Your Company',
            'email' => 'your@email.com',
            'phone' => '123-456-7890',
            'logo' => null, // Provide a default logo path
            'address' => 'Your Company Address',
        ]);
    }
}
