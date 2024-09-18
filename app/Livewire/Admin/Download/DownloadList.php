<?php

namespace App\Livewire\Admin\Download;

use App\Models\Download;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DownloadList extends Component
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
        $query = Download::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('downloads');

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

        $downloads = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.admin.download.download-list', [
            'downloads' => $downloads
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
    public function toggleStatus($downloadId)
    {
        // Get data
        $download = Download::find($downloadId);

        // Check user exists
        if (!$download) {
            $this->dispatch('error', 'User not found!');
            return;
        }

        // Change Status
        $download->update(['is_active' => !$download->is_active]);
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
        $download = Download::find($this->recordToDelete);

        // Check record exists
        if (!$download) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $download->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($downloadId)
    {
        $this->recordToDelete = $downloadId;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Download::withTrashed()->find($this->recordToDelete)->restore();
    }

    /**
     * Confirm force delete
     */
    public function confirmForceDelete($downloadId)
    {
        $this->recordToDelete = $downloadId;
        $this->dispatch('confirmForceDelete');
    }

    /**
     * Force delete record
     */
    #[On('forceDeleted')]
    public function forceDelete()
    {
        $download = Download::withTrashed()->find($this->recordToDelete);
        // $download->users()->sync();
        File::delete('storage/' . $download->file_path);
        $download->forceDelete();
    }
}
