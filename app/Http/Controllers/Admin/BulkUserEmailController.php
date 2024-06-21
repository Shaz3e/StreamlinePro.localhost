<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BulkEmail;
use App\Models\Email;
use App\Models\User;
use App\Trait\Admin\FormHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BulkUserEmailController extends Controller
{
    use FormHelper;

    public function index()
    {
        return redirect()->route('admin.email-management.bulk-emails.index');
    }

    /**
     * Show the form for creating a new resource for all users.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', BulkEmail::class);

        return view('admin.email-management.bulk-email.bulk-user-email.create');
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
        $userIds = User::where('is_active', 1)->pluck('id')->toArray();

        $bulkEmail = new BulkEmail();
        $bulkEmail->subject = $validated['subject'];
        $bulkEmail->content = $validated['content'];
        $bulkEmail->is_publish = $validated['is_publish'];
        // Convert send_date back to Y-m-d H:i:s format for MySQL storage
        $bulkEmail->send_date = Carbon::createFromFormat('d-M-Y h:i A', $validated['send_date'])->format('Y-m-d H:i:s');
        $bulkEmail->user_id = $userIds;
        $bulkEmail->is_sent_all_users = true;
        $bulkEmail->save();

        session()->flash('success', 'Email has been created successfully!');

        return $this->saveAndRedirect($request, 'email-management.bulk-emails', $bulkEmail->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(BulkEmail $bulkEmailUser)
    {
        // Check Authorize
        Gate::authorize('view', $bulkEmailUser);

        $emailList = Email::where('bulk_email_id', $bulkEmailUser->id)->paginate(10);

        return view('admin.email-management.bulk-email.bulk-user-email.show', [
            'bulkEmailUser' => $bulkEmailUser,
            'emailList' => $emailList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BulkEmail $bulkEmailUser)
    {
        // Check Authorize
        Gate::authorize('update', $bulkEmailUser);

        // stop editing if email has been sent
        if ($bulkEmailUser->is_sent) {
            session()->flash('error', 'You cannot edit a sent email!');
            return redirect()->back();
        }

        return view('admin.email-management.bulk-email.bulk-user-email.edit', [
            'bulkEmailUser' => $bulkEmailUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BulkEmail $bulkEmailUser)
    {
        // Check Authorize
        Gate::authorize('update', $bulkEmailUser);

        // stop editing if email has been sent
        if ($bulkEmailUser->is_sent) {
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

        $bulkEmailUser->subject = $validated['subject'];
        $bulkEmailUser->content = $validated['content'];
        $bulkEmailUser->is_publish = $validated['is_publish'];
        $bulkEmailUser->send_date = Carbon::createFromFormat('d-M-Y h:i A', $validated['send_date'])->format('Y-m-d H:i:s');
        $bulkEmailUser->save();

        // Flash message
        session()->flash('success', 'Email has been updated successfully!');

        return $this->saveAndRedirect($request, 'email-management.bulk-emails', $bulkEmailUser->id);
    }
}
