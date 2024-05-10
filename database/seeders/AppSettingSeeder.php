<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appSettings = [
            // General Setting
            ['name' => 'site_name', 'value' => 'Stream Line Pro'],
            ['name' => 'site_url', 'value' => null],
            ['name' => 'app_url', 'value' => null],
            ['name' => 'site_logo_light', 'value' => 'settings/logo/logo-light.png'],
            ['name' => 'site_logo_dark', 'value' => 'settings/logo/logo-dark.png'],
            ['name' => 'site_logo_small', 'value' => 'settings/logo/logo-sm.png'],
            ['name' => 'site_timezone', 'value' => 'UTC'],

            // Registration
            ['name' => 'can_admin_register', 'value' => 0],
            ['name' => 'can_admin_reset_password', 'value' => 0],
            ['name' => 'can_customer_register', 'value' => 1],
            ['name' => 'can_user_reset_password', 'value' => 1],
        ];

        DB::table('app_settings')->insert($appSettings);
    }
}
