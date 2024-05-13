<?php

namespace App\Livewire\Admin\SupportTicket;

use App\Models\Admin;
use App\Models\Department;
use App\Models\SupportTicket;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketStatus;
use App\Models\TodoStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SupportTicketList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    #[Url()]
    public $filterStatus;

    public $perPage = 10;

    #[Url()]
    public $filterInternalTickets = '';

    #[Url()]
    public $searchUser = '';

    #[Url()]
    public $users = [];

    #[Url()]
    public $searchStaff = '';

    #[Url()]
    public $staff = [];

    #[Url()]
    public $filterDepartmentTickets = '';

    #[Url()]
    public $searchDepartment = '';

    #[Url()]
    public $departments = [];

    #[Url()]
    public $filterByStatusTickets = '';

    #[Url()]
    public $filterByPriorityTickets = '';

    public $id;

    // record to delete
    public $recordToDelete;

    // Update todo status
    public $statuses = [];

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        // Get the logged-in admin's ID
        $adminId = Auth::guard('admin')->user()->id;

        // Retrieve the departments assigned to the logged-in admin/staff
        $admin = Admin::findOrFail($adminId);
        $departments = $admin->department_id;

        // Check if the logged-in admin is a super admin (with admin ID 1)
        if ($admin->hasRole(['superadmin', 'developer'])) {
            // If admin is super admin, fetch all support tickets
            $query = SupportTicket::query();
        } else {
            // Query support tickets based on the departments assigned to the admin/staff
            $query = SupportTicket::query()->where(function ($q) use ($departments, $adminId) {
                $q->whereIn('department_id', (array) $departments)
                    ->orWhere('admin_id', $adminId);
            });
        }

        // Get all columns in the required table
        $columns = Schema::getColumnListing('support_tickets');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        if ($this->filterInternalTickets !== '') {
            $query->where('is_internal', $this->filterInternalTickets);
        }
        
        if ($this->searchUser !== '') {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->searchUser . '%')
                    ->orWhere('email', 'like', '%' . $this->searchUser . '%');
            });
        }
        
        if ($this->searchStaff !== '') {
            $query->whereHas('admin', function ($q) {
                $q->where('name', 'like', '%' . $this->searchStaff . '%')
                    ->orWhere('email', 'like', '%' . $this->searchStaff . '%');
            });
        }

        if ($this->searchDepartment !== '') {
            $query->whereHas('department', function ($q) {
                $q->where('name', 'like', '%' . $this->searchDepartment . '%');
            });
        }

        if ($this->filterByStatusTickets !== '') {
            $query->where('support_ticket_status_id', $this->filterByStatusTickets);
        }

        if ($this->filterByPriorityTickets !== '') {
            $query->where('support_ticket_priority_id', $this->filterByPriorityTickets);
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        // Get all tickets
        $tickets = $query->orderBy('id', 'desc')
            ->paginate($this->perPage);

        // Get all ticket department
        $getDepartments = Department::all();

        // Get all ticket status
        $getTicketStatuses = SupportTicketStatus::all();

        // Get all ticket priority
        $getTicketPriorities = SupportTicketPriority::all();

        return view('livewire.admin.support-ticket.support-ticket-list', [
            'tickets' => $tickets,
            'getTicketStatuses' => $getTicketStatuses,
            'getTicketPriorities' => $getTicketPriorities,
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
     * Reset Filters
     */
    public function resetFilters()
    {
        $this->search = '';
        $this->searchUser = '';
        $this->searchStaff = '';
        $this->filterInternalTickets = '';
        $this->searchStaff = '';
        $this->filterByStatusTickets = '';
        $this->filterByPriorityTickets = '';
        $this->resetPage();
    }

    /**
     * Toggle Status
     */
    // public function updateStatus($ticketId)
    // {
    //     // Get data
    //     $ticket = SupportTicket::find($ticketId);

    //     // Check user exists
    //     if (!$ticket) {
    //         $this->dispatch('error', 'Support Ticket not found!');
    //         return;
    //     }
    //     // Change Status
    //     $ticket->update([
    //         'todo_status_id' => $this->statuses[$ticketId . '_status'],
    //     ]);

    //     $this->dispatch('statusChanged');
    // }

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
        $ticket = SupportTicket::find($this->recordToDelete);

        // Check record exists
        if (!$ticket) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $ticket->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($ticketId)
    {
        $this->recordToDelete = $ticketId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        SupportTicket::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($todoId)
    {
        $this->recordToDelete = $todoId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        SupportTicket::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
