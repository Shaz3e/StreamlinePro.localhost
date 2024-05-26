<?php

use App\Jobs\Common\Task\SendTaskOverdueReminderJob;
use App\Jobs\Staff\SendTaskReminderJob;
use App\Jobs\User\Invoice\SendInvoiceFirstOverDueNoticeJob;
use App\Jobs\User\Invoice\SendInvoiceFirstReminderBeforeDueDateJob;
use App\Jobs\User\Invoice\SendInvoiceNotificationsJob;
use App\Jobs\User\Invoice\SendInvoiceSecondOverDueNoticeJob;
use App\Jobs\User\Invoice\SendInvoiceSecondReminderBeforeDueDateJob;
use App\Jobs\User\Invoice\SendInvoiceThirdOverDueNoticeJob;
use App\Jobs\User\Invoice\SendInvoiceThirdReminderBeforeDueDateJob;
use App\Jobs\User\PromotionScheduleJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

/*
|--------------------------------------------------------------------------
| php /path/to/your/project/artisan queue:work --sleep=3
|--------------------------------------------------------------------------
|
| On production make sure to adjust the path to your project directory
| The --sleep=3 option in the queue:work command is a parameter that controls
| how long the queue worker will sleep (or pause) between processing jobs.
| In this case, --sleep=3 means that the queue worker will sleep for 3 seconds between processing each job.
| The --sleep option is useful for a few reasons:
|   1) Prevents overload:
|       By introducing a short delay between jobs, you can prevent the queue worker from overwhelming
|       your application or server with too many requests at once.
|   2) Allows for queue recovery:
|       If the queue worker crashes or is restarted, 
|       the --sleep option ensures that it will wait for a short period before processing new jobs,
|       allowing the queue to recover and preventing duplicate processing.
|   3) Improves performance:
|       By introducing a brief pause between jobs, you can help prevent performance issues caused by rapid-fire job processing.
*/

/**
 * Send task reminders to respective staff at regular intervals.
 *
 * Intervals:
 * - Every 15 minutes
 * - Every 1 hour
 * - Every 6 hours
 * - Every 12 hours
 * - Every 24 hours
 */
// Schedule::job(new SendTaskReminderJob)->everyFifteenMinutes();

/**
 * If the deadline has passed since the creation of the task.
 * Send task overdue reminder to assigned_to and created_by
 */
// Schedule::job(new SendTaskOverdueReminderJob)->everyMinute();

/**
 * Send Invoice as email when published_date equals today
 */
// Schedule::job(new SendInvoiceNotificationsJob)->daily();

/**
 * Send Invoice First Reminder when due_date 3 days from now
 */
// Schedule::job(new SendInvoiceFirstReminderBeforeDueDateJob)->daily();

/**
 * Send Invoice First Reminder when due_date 2 days from now
 */
// Schedule::job(new SendInvoiceSecondReminderBeforeDueDateJob)->daily();

/**
 * Send Invoice First Reminder when due_date 1 days from now
 */
// Schedule::job(new SendInvoiceThirdReminderBeforeDueDateJob)->daily();

 /**
 * Send Invoice First Overdue Reminder when due_date after 1 days from now
 */
// Schedule::job(new SendInvoiceFirstOverDueNoticeJob)->daily();

/**
 * Send Invoice Second Overdue Reminder when due_date after 2 days from now
 */
// Schedule::job(new SendInvoiceSecondOverDueNoticeJob)->daily();

/**
 * Send Invoice Third Overdue Reminder when due_date after 3 days from now
 */
// Schedule::job(new SendInvoiceThirdOverDueNoticeJob)->daily();

/**
 * Update Promotion is_active status based on time
 */
// Schedule::job(new PromotionScheduleJob)->daily();