<div class="card">
    <form action="{{ route('admin.settings.cronjobs.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card-header">
            <h5 class="card-title">Cron Jobs Settings</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h6>Task Reminders</h6>
                </div>
                <label for="SendTaskReminderJob" class="col-sm-6 col-form-label">Task Reminder</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="SendTaskReminderJob" value="0">
                        <input type="checkbox" id="SendTaskReminderJob" name="SendTaskReminderJob" switch="none"
                            value="1" @if (DiligentCreators('SendTaskReminderJob') == 1) checked @endif>
                        <label for="SendTaskReminderJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('SendTaskReminderJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <label for="SendTaskOverdueReminderJob" class="col-sm-6 col-form-label">Daily Task
                    Reminder</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="SendTaskOverdueReminderJob" value="0">
                        <input type="checkbox" id="SendTaskOverdueReminderJob" name="SendTaskOverdueReminderJob"
                            switch="none" value="1" @if (DiligentCreators('SendTaskOverdueReminderJob') == 1) checked @endif>
                        <label for="SendTaskOverdueReminderJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('SendTaskOverdueReminderJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <label for="DailyTaskReportJob" class="col-sm-6 col-form-label">Daily Task
                    Report</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="DailyTaskReportJob" value="0">
                        <input type="checkbox" id="DailyTaskReportJob" name="DailyTaskReportJob" switch="none"
                            value="1" @if (DiligentCreators('DailyTaskReportJob') == 1) checked @endif>
                        <label for="DailyTaskReportJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('DailyTaskReportJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}

            <div class="row mb-3">
                <div class="col-md-12">
                    <h6>Send Invoice Reminder</h6>
                </div>
                <label for="DailyInvoiceNotificationJob" class="col-sm-6 col-form-label">Daily Invoice
                    Reminder</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="DailyInvoiceNotificationJob" value="0">
                        <input type="checkbox" id="DailyInvoiceNotificationJob" name="DailyInvoiceNotificationJob"
                            switch="none" value="1" @if (DiligentCreators('DailyInvoiceNotificationJob') == 1) checked @endif>
                        <label for="DailyInvoiceNotificationJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('DailyInvoiceNotificationJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}


                <label for="GenerateRecurringInvoiceJob" class="col-sm-6 col-form-label">Generate Recurring
                    Invoices</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="GenerateRecurringInvoiceJob" value="0">
                        <input type="checkbox" id="GenerateRecurringInvoiceJob" name="GenerateRecurringInvoiceJob"
                            switch="none" value="1" @if (DiligentCreators('GenerateRecurringInvoiceJob') == 1) checked @endif>
                        <label for="GenerateRecurringInvoiceJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('GenerateRecurringInvoiceJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- ./col --}}

                <label for="SendInvoiceFirstReminderBeforeDueDateJob" class="col-sm-6 col-form-label">First
                    Reminder Before Due Date</label>
                <div class="col-md-2">
                    <div class="square-switch">
                        <input type="hidden" name="SendInvoiceFirstReminderBeforeDueDateJob" value="0">
                        <input type="checkbox" id="SendInvoiceFirstReminderBeforeDueDateJob"
                            name="SendInvoiceFirstReminderBeforeDueDateJob" switch="none" value="1"
                            @if (DiligentCreators('SendInvoiceFirstReminderBeforeDueDateJob') == 1) checked @endif>
                        <label for="SendInvoiceFirstReminderBeforeDueDateJob" data-on-label="On"
                            data-off-label="Off"></label>
                    </div>
                    @error('SendInvoiceFirstReminderBeforeDueDateJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}

                <label for="invoice_first_reminder_before_due_date"
                    class="col-sm-2 col-form-label text-end">Day(s)</label>
                <div class="col-md-2 mt-1">
                    <input type="number" name="invoice_first_reminder_before_due_date"
                        class="form-control form-control-sm"
                        value="{{ DiligentCreators('invoice_first_reminder_before_due_date') ?? 3 }}"
                        placeholder="days" min="1">
                </div>
                {{-- /.col --}}

                <label for="SendInvoiceSecondReminderBeforeDueDateJob" class="col-sm-6 col-form-label">Second
                    Reminder Before Due Date</label>
                <div class="col-sm-2">
                    <div class="square-switch">
                        <input type="hidden" name="SendInvoiceSecondReminderBeforeDueDateJob" value="0">
                        <input type="checkbox" id="SendInvoiceSecondReminderBeforeDueDateJob"
                            name="SendInvoiceSecondReminderBeforeDueDateJob" switch="none" value="1"
                            @if (DiligentCreators('SendInvoiceSecondReminderBeforeDueDateJob') == 1) checked @endif>
                        <label for="SendInvoiceSecondReminderBeforeDueDateJob" data-on-label="On"
                            data-off-label="Off"></label>
                    </div>
                    @error('SendInvoiceSecondReminderBeforeDueDateJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}

                <label for="invoice_second_reminder_before_due_date"
                    class="col-sm-2 col-form-label text-end">Day(s)</label>
                <div class="col-md-2 mt-1">
                    <input type="number" name="invoice_second_reminder_before_due_date"
                        class="form-control form-control-sm"
                        value="{{ DiligentCreators('invoice_second_reminder_before_due_date') ?? 2 }}"
                        placeholder="days" min="1">
                </div>
                {{-- /.col --}}

                <label for="SendInvoiceThirdReminderBeforeDueDateJob" class="col-sm-6 col-form-label">Third
                    Reminder Before Due Date</label>
                <div class="col-sm-2">
                    <div class="square-switch">
                        <input type="hidden" name="SendInvoiceThirdReminderBeforeDueDateJob" value="0">
                        <input type="checkbox" id="SendInvoiceThirdReminderBeforeDueDateJob"
                            name="SendInvoiceThirdReminderBeforeDueDateJob" switch="none" value="1"
                            @if (DiligentCreators('SendInvoiceThirdReminderBeforeDueDateJob') == 1) checked @endif>
                        <label for="SendInvoiceThirdReminderBeforeDueDateJob" data-on-label="On"
                            data-off-label="Off"></label>
                    </div>
                    @error('SendInvoiceThirdReminderBeforeDueDateJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}

                <label for="invoice_third_reminder_before_due_date"
                    class="col-sm-2 col-form-label text-end">Day(s)</label>
                <div class="col-md-2 mt-1">
                    <input type="number" name="invoice_third_reminder_before_due_date"
                        class="form-control form-control-sm"
                        value="{{ DiligentCreators('invoice_third_reminder_before_due_date') ?? 1 }}"
                        placeholder="days" min="1">
                </div>
                {{-- /.col --}}

                <label for="SendInvoiceFirstOverDueNoticeJob" class="col-sm-6 col-form-label">
                    First Invoice Over Due Notice
                </label>
                <div class="col-sm-2">
                    <div class="square-switch">
                        <input type="hidden" name="SendInvoiceFirstOverDueNoticeJob" value="0">
                        <input type="checkbox" id="SendInvoiceFirstOverDueNoticeJob"
                            name="SendInvoiceFirstOverDueNoticeJob" switch="none" value="1"
                            @if (DiligentCreators('SendInvoiceFirstOverDueNoticeJob') == 1) checked @endif>
                        <label for="SendInvoiceFirstOverDueNoticeJob" data-on-label="On"
                            data-off-label="Off"></label>
                    </div>
                    @error('SendInvoiceFirstOverDueNoticeJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}

                <label for="invoice_first_overdue_notice" class="col-sm-2 col-form-label text-end">Day(s)</label>
                <div class="col-md-2 mt-1">
                    <input type="number" name="invoice_first_overdue_notice" class="form-control form-control-sm"
                        value="{{ DiligentCreators('invoice_first_overdue_notice') ?? 1 }}" placeholder="days"
                        min="1">
                </div>
                {{-- /.col --}}

                <label for="SendInvoiceSecondOverDueNoticeJob" class="col-sm-6 col-form-label">
                    Second Invoice Over Due Notice
                </label>
                <div class="col-sm-2">
                    <div class="square-switch">
                        <input type="hidden" name="SendInvoiceSecondOverDueNoticeJob" value="0">
                        <input type="checkbox" id="SendInvoiceSecondOverDueNoticeJob"
                            name="SendInvoiceSecondOverDueNoticeJob" switch="none" value="1"
                            @if (DiligentCreators('SendInvoiceSecondOverDueNoticeJob') == 1) checked @endif>
                        <label for="SendInvoiceSecondOverDueNoticeJob" data-on-label="On"
                            data-off-label="Off"></label>
                    </div>
                    @error('SendInvoiceSecondOverDueNoticeJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}

                <label for="invoice_second_overdue_notice" class="col-sm-2 col-form-label text-end">Day(s)</label>
                <div class="col-md-2 mt-1">
                    <input type="number" name="invoice_second_overdue_notice" class="form-control form-control-sm"
                        value="{{ DiligentCreators('invoice_second_overdue_notice') ?? 2 }}" placeholder="days"
                        min="1">
                </div>
                {{-- /.col --}}

                <label for="SendInvoiceThirdOverDueNoticeJob" class="col-sm-6 col-form-label">
                    Third Invoice Over Due Notice
                </label>
                <div class="col-sm-2">
                    <div class="square-switch">
                        <input type="hidden" name="SendInvoiceThirdOverDueNoticeJob" value="0">
                        <input type="checkbox" id="SendInvoiceThirdOverDueNoticeJob"
                            name="SendInvoiceThirdOverDueNoticeJob" switch="none" value="1"
                            @if (DiligentCreators('SendInvoiceThirdOverDueNoticeJob') == 1) checked @endif>
                        <label for="SendInvoiceThirdOverDueNoticeJob" data-on-label="On"
                            data-off-label="Off"></label>
                    </div>
                    @error('SendInvoiceThirdOverDueNoticeJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}

                <label for="invoice_third_overdue_notice" class="col-sm-2 col-form-label text-end">Day(s)</label>
                <div class="col-md-2 mt-1">
                    <input type="number" name="invoice_third_overdue_notice" class="form-control form-control-sm"
                        value="{{ DiligentCreators('invoice_third_overdue_notice') ?? 3 }}" placeholder="days"
                        min="1">
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}


            <div class="row mb-3">
                <h6>Auto Enable/Disable Promotions</h6>
                <label for="PromotionScheduleJob" class="col-sm-6 col-form-label">Promotion Schedule</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="PromotionScheduleJob" value="0">
                        <input type="checkbox" id="PromotionScheduleJob" name="PromotionScheduleJob" switch="none"
                            value="1" @if (DiligentCreators('PromotionScheduleJob') == 1) checked @endif>
                        <label for="PromotionScheduleJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('PromotionScheduleJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}

            <div class="row mb-3">
                <div class="col-md-12">
                    <h6>Network Gateway Webhook (NGeniuse Payment Gateway)</h6>
                </div>
                <label for="NgeniusGatewayJob" class="col-sm-6 col-form-label">Network Gateway</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="NgeniusGatewayJob" value="0">
                        <input type="checkbox" id="NgeniusGatewayJob" name="NgeniusGatewayJob" switch="none"
                            value="1" @if (DiligentCreators('NgeniusGatewayJob') == 1) checked @endif>
                        <label for="NgeniusGatewayJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('NgeniusGatewayJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}

            <div class="row mb-3">
                <div class="col-md-12">
                    <h6>Send Bulk Jobs</h6>
                </div>
                <label for="StoreBulkEmailJob" class="col-sm-6 col-form-label">Store Bulk Email</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="StoreBulkEmailJob" value="0">
                        <input type="checkbox" id="StoreBulkEmailJob" name="StoreBulkEmailJob" switch="none"
                            value="1" @if (DiligentCreators('StoreBulkEmailJob') == 1) checked @endif>
                        <label for="StoreBulkEmailJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('StoreBulkEmailJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <label for="SendEmailJob" class="col-sm-6 col-form-label">Send Bulk Email</label>
                <div class="col-sm-6">
                    <div class="square-switch">
                        <input type="hidden" name="SendEmailJob" value="0">
                        <input type="checkbox" id="SendEmailJob" name="SendEmailJob" switch="none" value="1"
                            @if (DiligentCreators('SendEmailJob') == 1) checked @endif>
                        <label for="SendEmailJob" data-on-label="On" data-off-label="Off"></label>
                    </div>
                    @error('SendEmailJob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}

        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Save Cronjobs Settings" />
        </div>
        {{-- /.card-footer --}}
    </form>
</div>
{{-- /.card --}}

@push('styles')
@endpush

@push('scripts')
@endpush
