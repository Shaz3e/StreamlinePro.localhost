<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class MailSettingController extends Controller
{
    public function mail()
    {
        // Check authorize
        Gate::authorize('mail', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function mailStore(Request $request)
    {
        // Check authorize
        Gate::authorize('mailStore', AppSetting::class);

        // Mail From Setting
        if ($request->has('mailFromSetting')) {
            // Validate the request data based on the rules
            $validated = $request->validate([
                'mail_from_name' => 'required|max:255',
                'mail_from_address' => 'required|max:255',
                'daily_email_sending_limit' => 'required|integer',
            ]);

            // Update or create the setting in the database
            AppSetting::updateOrCreate(
                ['name' => 'daily_email_sending_limit'],
                ['value' => $validated['daily_email_sending_limit']]
            );

            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            $envData = [
                'MAIL_FROM_NAME' => "\"{$validated['mail_from_name']}\"",
                'MAIL_FROM_ADDRESS' => "\"{$validated['mail_from_address']}\"",
            ];

            // Update the key-value pairs
            foreach ($envData as $key => $value) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            }

            File::put($envPath, $envContent);
        }

        // Mail SMTP Setting
        if ($request->has('mailSmtpSetting')) {
            // Validate the request data based on the rules
            $validated = $request->validate([
                'smtp_email' => 'required|email|max:255',
                'smtp_password' => 'required|max:255',
                'smtp_host' => 'required|max:255',
                'smtp_port' => 'required|max:255',
                'smtp_encryptions' => 'required|max:255',
            ]);

            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            $envData = [
                'MAIL_USERNAME' => $validated['smtp_email'],
                'MAIL_PASSWORD' => "\"{$validated['smtp_password']}\"",
                'MAIL_HOST' => $validated['smtp_host'],
                'MAIL_PORT' => $validated['smtp_port'],
                'MAIL_ENCRYPTION' => $validated['smtp_encryptions'],
            ];

            // Update the key-value pairs
            foreach ($envData as $key => $value) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            }

            File::put($envPath, $envContent);
        }

        // Send Test Email
        if ($request->has('testMailSmtpSetting')) {
            // Send test email without mailable
            // Extract SMTP settings from the request
            $smtpDetails = $request->only(['smtp_email', 'smtp_password', 'smtp_host', 'smtp_port', 'smtp_encryptions']);

            // Dynamically configure the mail settings
            config([
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $smtpDetails['smtp_host'],
                'mail.mailers.smtp.port' => $smtpDetails['smtp_port'],
                'mail.mailers.smtp.encryption' => $smtpDetails['smtp_encryptions'],
                'mail.mailers.smtp.username' => $smtpDetails['smtp_email'],
                'mail.mailers.smtp.password' => $smtpDetails['smtp_password'],
                'mail.from.address' => $smtpDetails['smtp_email'],
                'mail.from.name' => 'Test Mail',
            ]);

            // Send test email
            Mail::raw('This is a test email.', function ($message) use ($smtpDetails) {
                $message->to($smtpDetails['smtp_email'])
                    ->from($smtpDetails['smtp_email'], 'Test Mail')
                    ->subject('Test SMTP Configuration');
            });

            return back()->with('success', 'Test email sent successfully!');
        }

        if ($request->has('mailBackupSmtpSetting')) {
            // Validate the request data based on the rules
            $validated = $request->validate([
                'backup_smtp_email' => 'required|email|max:255',
                'backup_smtp_password' => 'required|max:255',
                'backup_smtp_host' => 'required|max:255',
                'backup_smtp_port' => 'required|max:255',
                'backup_smtp_encryptions' => 'required|max:255',
            ]);

            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            $envData = [
                'MAIL_BACKUP_USERNAME' => $validated['backup_smtp_email'],
                'MAIL_BACKUP_PASSWORD' => "\"{$validated['backup_smtp_password']}\"",
                'MAIL_BACKUP_HOST' => $validated['backup_smtp_host'],
                'MAIL_BACKUP_PORT' => $validated['backup_smtp_port'],
                'MAIL_BACKUP_ENCRYPTION' => $validated['backup_smtp_encryptions'],
            ];

            // Update the key-value pairs
            foreach ($envData as $key => $value) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            }

            File::put($envPath, $envContent);
        }

        // Optimize Clear
        Artisan::call('optimize:clear');

        // Redirect back with success message
        return back()->with('success', 'Setting Saved');
    }
}
