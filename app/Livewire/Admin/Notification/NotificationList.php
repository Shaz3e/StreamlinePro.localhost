<?php

namespace App\Livewire\Admin\Notification;

use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $perPage = 10;

    public $id;

    public $read;
    public $searchUser = '';
    public $searchAdmin = '';

    // record to delete
    public $recordToDelete;

    /**
     * Main Blade Render
     */
    public function render()
    {
        // Get logged in admin/staff
        $loggedInStaff = Auth::guard('admin')->user();

        // Check if staff is super admin
        $staff = Admin::find($loggedInStaff->id);

        // Show all records to super admin
        if ($staff->hasRole(['superadmin', 'developer'])) {
            $query = Notification::query();
        } else {
            // Show only logged in user notification
            $query = Notification::query()->where('admin_id', $loggedInStaff->id);
        }

        // Get all columns in the required table
        $columns = Schema::getColumnListing('notifications');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Filter records based on read status
        if ($this->read === 'true') {
            $query->whereNotNull('read_at'); // Read notifications
        } elseif ($this->read === 'false') {
            $query->whereNull('read_at'); // Unread notifications
        }

        // Filter records based on user
        if ($this->searchUser !== '') {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->searchUser . '%')
                    ->orWhere('email', 'like', '%' . $this->searchUser . '%');
            });
        }
        // Filter records based on admin
        if ($this->searchAdmin !== '') {
            $query->whereHas('admin', function ($q) {
                $q->where('name', 'like', '%' . $this->searchAdmin . '%')
                    ->orWhere('email', 'like', '%' . $this->searchAdmin . '%');
            });
        }


        $notifications = $query->latest()->paginate($this->perPage);

        return view('livewire.admin.notification.notification-list', [
            'notifications' => $notifications
        ]);
    }

    /**
     * Reset Search
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Update perPage records
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    /**
     * Toggle Status
     */
    public function markAsRead($notificationId)
    {
        // Get data
        $notification = Notification::find($notificationId);

        // Check user exists
        if (!$notification) {
            $this->dispatch('error', 'Notification not found!');
            return;
        }

        // Change Status
        $notification->update([
            'read_at' => now()
        ]);

        return redirect()->route($notification->route_name, $notification->model_id);
    }

    /**
     * Confirm Delete
     */
    public function confirmDelete($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('showDeleteConfirmation');
    }

    /**
     * Delete Record
     */
    #[On('deleteConfirmed')]
    public function delete()
    {
        // Check if a record to delete is set
        if (!$this->recordToDelete) {
            $this->dispatch('error');
            return;
        }

        // get id
        $notification = Notification::find($this->recordToDelete);

        // Check record exists
        if (!$notification) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $notification->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }
}
