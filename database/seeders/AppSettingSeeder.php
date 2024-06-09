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
            ['name' => 'site_url', 'value' => config('app.url')],
            ['name' => 'app_url', 'value' => config('app.url')],
            ['name' => 'notification_email', 'value' => null],
            ['name' => 'site_logo_light', 'value' => 'settings/logo/logo-light.png'],
            ['name' => 'site_logo_dark', 'value' => 'settings/logo/logo-dark.png'],
            ['name' => 'site_logo_small', 'value' => 'settings/logo/logo-sm.png'],
            ['name' => 'site_timezone', 'value' => 'UTC'],
            ['name' => 'app_address', 'value' => null],
            ['name' => 'app_zipcode', 'value' => null],
            ['name' => 'app_city', 'value' => null],
            ['name' => 'app_state', 'value' => null],
            ['name' => 'app_country', 'value' => null],

            // Authentication
            ['name' => 'can_admin_register', 'value' => 0],
            ['name' => 'can_admin_reset_password', 'value' => 0],
            ['name' => 'can_customer_register', 'value' => 1],
            ['name' => 'can_user_reset_password', 'value' => 1],

            ['name' => 'login_page_heading', 'value' => null],
            ['name' => 'login_page_heading_color', 'value' => null],
            ['name' => 'login_page_heading_bg_color', 'value' => null],
            ['name' => 'login_page_text', 'value' => null],
            ['name' => 'login_page_text_color', 'value' => null],
            ['name' => 'login_page_text_bg_color', 'value' => null],
            ['name' => 'login_page_image', 'value' => 'settings/page/login-page.jpg'],

            ['name' => 'register_page_heading', 'value' => null],
            ['name' => 'register_page_heading_color', 'value' => null],
            ['name' => 'register_page_heading_bg_color', 'value' => null],
            ['name' => 'register_page_text', 'value' => null],
            ['name' => 'register_page_text_color', 'value' => null],
            ['name' => 'register_page_text_bg_color', 'value' => null],
            ['name' => 'register_page_image', 'value' => 'settings/page/register-page.jpg'],

            ['name' => 'reset_page_heading', 'value' => null],
            ['name' => 'reset_page_heading_color', 'value' => null],
            ['name' => 'reset_page_heading_bg_color', 'value' => null],
            ['name' => 'reset_page_text', 'value' => null],
            ['name' => 'reset_page_text_color', 'value' => null],
            ['name' => 'reset_page_text_bg_color', 'value' => null],
            ['name' => 'reset_page_image', 'value' => 'settings/page/reset-page.jpg'],

            // Dashboard Setting
            ['name' => 'can_access_task_summary', 'value' => json_encode(["superadmin", "tester", "developer", "admin", "manager", "staff"])],
            ['name' => 'can_access_user_summary', 'value' => json_encode(["superadmin", "tester", "developer"])],
            ['name' => 'can_access_support_ticket_summary', 'value' => json_encode(["superadmin", "tester", "developer"])],
            ['name' => 'can_access_invoice_summary', 'value' => json_encode(["superadmin", "tester", "developer"])],
            ['name' => 'can_access_pulse_dashboard', 'value' => json_encode(["superadmin", "tester", "developer"])],

            /**
             * Payment Methods
             */
            // Stripe
            ['name' => 'stripe', 'value' => 0],
            ['name' => 'stripe_display_name', 'value' => 'Stripe'],
            ['name' => 'stripe_hosted_checkout', 'value' => 0],
            ['name' => 'stripe_hosted_checkout_display_name', 'value' => 'Hosted Checkout'],
            // Ngenius Network
            ['name' => 'ngenius', 'value' => 0],
            ['name' => 'ngenius_display_name', 'value' => 'Ngenius Network'],
            ['name' => 'ngenius_hosted_checkout', 'value' => 0],
            ['name' => 'ngenius_hosted_checkout_display_name', 'value' => 'Hosted Checkout'],

            // Currency Setting
            ['name' => 'currency', 'value' => 1],
        ];

        DB::table('app_settings')->insert($appSettings);
    }
}
