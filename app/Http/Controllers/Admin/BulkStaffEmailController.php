<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BulkEmail;
use App\Models\Email;
use App\Trait\Admin\FormHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BulkStaffEmailController extends Controller
{
    use FormHelper;

    public function index()
    {
        return redirect()->route('admin.email-management.bulk-emails.index');
    }

    /**
     * Show the form for creating a new resource for all staff.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', BulkEmail::class);

        return view('admin.email-management.bulk-email.bulk-staff-email.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check Authorize
        Gate::authorize('create', BulkEmail::class);

        // Convert 'datetime-local' format to 'd-M-Y h:i A' before validation
        if ($request->send_date) {
            try {
                $sendDate = Carbon::createFromFormat('Y-m-d\TH:i', $request->send_date)->format('d-M-Y h:i A');
                $request->merge(['send_date' => $sendDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['send_date' => 'The send date is not valid.']);
            }
        }

        // Validate data
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_publish' => 'required|boolean',
            'send_date' => 'required|date_format:"d-M-Y h:i A"|after_or_equal:' . now()->format('d-M-Y h:i A'),
        ]);

        // Fetch user IDs from users table where is_active = 1
        $adminIds = Admin::where('is_active', 1)->pluck('id')->toArray();

        $bulkEmail = new BulkEmail();
        $bulkEmail->subject = $validated['subject'];
        $bulkEmail->content = $validated['content'];
        $bulkEmail->is_publish = $validated['is_publish'];
        // Convert send_date back to Y-m-d H:i:s format for MySQL storage
        $bulkEmail->send_date = Carbon::createFromFormat('d-M-Y h:i A', $validated['send_date'])->format('Y-m-d H:i:s');
        $bulkEmail->admin_id = $adminIds;
        $bulkEmail->is_sent_all_admins = true;
        $bulkEmail->save();

        session()->flash('success', 'Email has been created successfully!');

        return $this->saveAndRedirect($request, 'email-management.bulk-emails', $bulkEmail->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(BulkEmail $bulkEmailStaff)
    {
        // Check Authorize
        Gate::authorize('view', $bulkEmailStaff);

        $emailList = Email::where('bulk_email_id', $bulkEmailStaff->id)->paginate(10);

        return view('admin.email-management.bulk-email.bulk-staff-email.show', [
            'bulkEmailStaff' => $bulkEmailStaff,
            'emailList' => $emailList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BulkEmail $bulkEmailStaff)
    {
        // Check Authorize
        Gate::authorize('update', $bulkEmailStaff);

        // stop editing if email has been sent
        if ($bulkEmailStaff->is_sent) {
            session()->flash('error', 'You cannot edit a sent email!');
            return redirect()->back();
        }

        return view('admin.email-management.bulk-email.bulk-staff-email.edit', [
            'bulkEmailStaff' => $bulkEmailStaff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BulkEmail $bulkEmailStaff)
    {
        // Check Authorize
        Gate::authorize('update', $bulkEmailStaff);

        // stop editing if email has been sent
        if ($bulkEmailStaff->is_sent) {
            session()->flash('error', 'You cannot edit a sent email!');
            return redirect()->back();
        }

        // Convert 'datetime-local' format to 'd-M-Y h:i A' before validation
        if ($request->send_date) {
            try {
                $sendDate = Carbon::createFromFormat('Y-m-d\TH:i', $request->send_date)->format('d-M-Y h:i A');
                $request->merge(['send_date' => $sendDate]);
            } catch (\Exception $e) {
                return back()->withErrors(['send_date' => 'The send date is not valid.']);
            }
        }

        // Validate data
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_publish' => 'required|boolean',
            'send_date' => 'required|date_format:"d-M-Y h:i A"|after_or_equal:' . now()->format('d-M-Y h:i A'),
        ]);

        $bulkEmailStaff->subject = $validated['subject'];
        $bulkEmailStaff->content = $validated['content'];
        $bulkEmailStaff->is_publish = $validated['is_publish'];
        $bulkEmailStaff->send_date = Carbon::createFromFormat('d-M-Y h:i A', $validated['send_date'])->format('Y-m-d H:i:s');
        $bulkEmailStaff->save();

        // Flash message
        session()->flash('success', 'Email has been updated successfully!');

        return $this->saveAndRedirect($request, 'email-management.bulk-emails', $bulkEmailStaff->id);
    }
}
