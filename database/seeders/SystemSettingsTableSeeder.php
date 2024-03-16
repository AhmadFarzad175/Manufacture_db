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
            'logo' => 'setting_logos//g9Jn7KFsWVQl1GkN0zo8y50JzWc4iNuSLR1wp5YT.png', // Provide a default logo path
            'address' => 'Your Company Address',
        ]);
    }
}
