<?php

namespace App\Livewire\Admin\Lead;

use App\Models\Admin;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LeadList extends Component
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

    public $showDuplicates = false; // New property to toggle duplicate leads

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
            $query = Lead::query();
        } else {
            // Show only logged in user tasks
            $query = Lead::query()
                ->orWhere([
                    'assigned_to' => $loggedInStaff->id,
                    'updated_by' => $loggedInStaff->id,
                    'assigned_by' => $loggedInStaff->id,
                    'assigned_to' => $loggedInStaff->id,
                ]);
        }


        // Get all columns in the required table
        $columns = Schema::getColumnListing('leads');

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

        // Apply duplicate filter
        if ($this->showDuplicates) {
            $query->leadsWithSameEmailOrPhone(); // Call the scope directly
        }

        // Get the leads and paginate the result
        $leads = $query->orderBy('id', 'desc')->paginate($this->perPage);

        // Loop through each lead and check if there are duplicates based on email or phone
        foreach ($leads as $lead) {
            // Count other leads with the same email or phone
            $lead->duplicates = Lead::where(function ($q) use ($lead) {
                $q->where('email', $lead->email)
                    ->orWhere('phone', $lead->phone);
            })->where('id', '!=', $lead->id) // Exclude the current lead
                ->count();
        }

        return view('livewire.admin.lead.lead-list', [
            'leads' => $leads
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
        $lead = Lead::find($this->recordToDelete);

        // Check record exists
        if (!$lead) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $lead->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($leadId)
    {
        $this->recordToDelete = $leadId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Lead::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        Lead::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
