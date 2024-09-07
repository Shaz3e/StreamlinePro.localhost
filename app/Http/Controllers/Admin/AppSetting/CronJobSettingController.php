<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CronJobSettingController extends Controller
{
    public function cronjobs()
    {
        // Check authorize
        Gate::authorize('cronjobs', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function cronjobsStore(Request $request)
    {
        // Check authorize
        Gate::authorize('cronjobsStore', AppSetting::class);

        // Validate the request data based on the rules
        $validated = $request->validate([
            'SendTaskReminderJob' => 'required|boolean',
            'SendTaskOverdueReminderJob' => 'required|boolean',

            'DailyInvoiceNotificationJob' => 'required|boolean',

            'SendInvoiceFirstReminderBeforeDueDateJob' => 'required|boolean',
            'invoice_first_reminder_before_due_date' => 'required|min:1|integer',

            'SendInvoiceSecondReminderBeforeDueDateJob' => 'required|boolean',
            'invoice_second_reminder_before_due_date' => 'required|min:1|integer',

            'SendInvoiceThirdReminderBeforeDueDateJob' => 'required|boolean',
            'invoice_third_reminder_before_due_date' => 'required|min:1|integer',

            'SendInvoiceFirstOverDueNoticeJob' => 'required|boolean',
            'invoice_first_overdue_notice' => 'required|min:1|integer',

            'SendInvoiceSecondOverDueNoticeJob' => 'required|boolean',
            'invoice_second_overdue_notice' => 'required|min:1|integer',

            'SendInvoiceThirdOverDueNoticeJob' => 'required|boolean',
            'invoice_third_overdue_notice' => 'required|min:1|integer',

            'GenerateRecurringInvoiceJob' => 'required|boolean',

            'PromotionScheduleJob' => 'required|boolean',
            'NgeniusGatewayJob' => 'required|boolean',
            'StoreBulkEmailJob' => 'required|boolean',
            'SendEmailJob' => 'required|boolean',
        ]);

        // Loop through each validated field and update or create the settings
        foreach ($validated as $key => $value) {
            AppSetting::updateOrCreate(
                ['name' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Setting Saved');
    }
}
