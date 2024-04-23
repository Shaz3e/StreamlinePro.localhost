<?php

namespace App\Livewire\Admin\Staff;

use App\Models\Admin;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class StaffList extends Component
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
        $query = Admin::query()
            ->where('id', '!=', 1);

        // Get all columns in the required table
        $columns = Schema::getColumnListing('admins');

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

        $staffList = $query->orderBy('id', 'asc')->paginate($this->perPage);

        return view('livewire.admin.staff.staff-list', [
            'staffList' => $staffList
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
    public function toggleStatus($staffId)
    {
        // Get data
        $staff = Admin::find($staffId);

        if ($staff->id === 1) {
            session()->flash('error', 'You cannot change status of super admin!');
            return redirect()->route('admin.staff.index');
        }

        // Check record exists
        if (!$staff) {
            $this->dispatch('error', 'Staff not found!');
            return;
        }

        // Change Status
        $staff->update(['is_active' => !$staff->is_active]);

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
        $staff = Admin::find($this->recordToDelete);

        if ($staff->id === 1) {
            session()->flash('error', 'You cannot delete the super admin!');
            return redirect()->route('admin.staff.index');
        }

        // Check record exists
        if (!$staff) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $staff->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($adminId)
    {
        $this->recordToDelete = $adminId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Admin::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($adminId)
    {
        $this->recordToDelete = $adminId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        Admin::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
