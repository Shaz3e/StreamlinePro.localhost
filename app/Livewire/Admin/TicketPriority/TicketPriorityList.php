<?php

namespace App\Livewire\Admin\TicketPriority;

use App\Models\SupportTicketPriority;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TicketPriorityList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $perPage = 10;

    public $id;

    // record to delete
    public $recordToDelete;

    // Show deleted records
    public $showDeleted = false;

    /**
     * Main Blade Render
     */
    public function render()
    {
        $query = SupportTicketPriority::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('support_ticket_priorities');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Apply filter for deleted records if the option is selected
        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $ticketPriorityList = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.ticket-priority.ticket-priority-list', [
            'ticketPriorityList' => $ticketPriorityList
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
    public function toggleStatus($ticketPriorityId)
    {
        // Get data
        $ticketPriority = SupportTicketPriority::find($ticketPriorityId);

        // Check user exists
        if (!$ticketPriority) {
            $this->dispatch('error', 'Ticket Priority not found!');
            return;
        }

        // Change Status
        $ticketPriority->update(['is_active' => !$ticketPriority->is_active]);

        // dipatch event
        $this->dispatch('statusChanged');
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
        $ticketPriority = SupportTicketPriority::find($this->recordToDelete);

        // Check record exists
        if (!$ticketPriority) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $ticketPriority->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($ticketPriorityId)
    {
        $this->recordToDelete = $ticketPriorityId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        SupportTicketPriority::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($ticketStatusId)
    {
        $this->recordToDelete = $ticketStatusId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        SupportTicketPriority::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
