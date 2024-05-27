<?php

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CurrencyList extends Component
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
        $query = Currency::query();

        // Get all columns in the required table
        $columns = Schema::getColumnListing('currencies');

        // Filter records based on search query
        if ($this->search !== '') {
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        $currencies = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.admin.currency.currency-list', [
            'currencies' => $currencies
        ]);
    }

    /**
     * Toggle Status
     */
    public function toggleStatus($id)
    {
        // Get data
        $currency = Currency::find($id);

        // Check user exists
        if (!$currency) {
            $this->dispatch('error', 'Currency not found!');
            return;
        }

        // Change Status
        $currency->update(['is_active' => !$currency->is_active]);
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
        $currency = Currency::find($this->recordToDelete);

        // Check record exists
        if (!$currency) {
            $this->dispatch('error');
            return;
        }

        // Delete record
        $currency->delete();

        // Reset the record to delete
        $this->recordToDelete = null;
    }

    /**
     * Confirm Restore
     */
    public function confirmRestore($id)
    {
        $this->recordToDelete = $id;
        $this->dispatch('confirmRestore');
    }

    /**
     * Restore record
     */
    #[On('restored')]
    public function restore()
    {
        Currency::withTrashed()->find($this->recordToDelete)->restore();
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
        Currency::withTrashed()->find($this->recordToDelete)->forceDelete();
    }
}
