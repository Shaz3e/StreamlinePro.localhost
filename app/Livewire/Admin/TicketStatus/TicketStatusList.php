<?php

namespace App\Livewire\Admin\TicketStatus;

use App\Models\SupportTicketStatus;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TicketStatusList extends Component
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
        $query = SupportTicketStatus::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('support_ticket_statuses');

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

        $ticketStatusList = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.ticket-status.ticket-status-list', [
            'ticketStatusList' => $ticketStatusList
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
    public function toggleStatus($ticketStatusId)
    {
        // Get data
        $ticketStatus = SupportTicketStatus::find($ticketStatusId);

        // Check user exists
        if (!$ticketStatus) {
            $this->dispatch('error', 'Ticket Status not found!');
            return;
        }

        // Change Status
        $ticketStatus->update(['is_active' => !$ticketStatus->is_active]);

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
        $ticketStatus = SupportTicketStatus::find($this->recordToDelete);

        // Check record exists
        if (!$ticketStatus) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $ticketStatus->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($todoStatusId)
    {
        $this->recordToDelete = $todoStatusId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        SupportTicketStatus::withTrashed()->find($this->recordToDelete)->restore();
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
        SupportTicketStatus::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
