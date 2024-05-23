<?php

namespace App\Livewire\User\SupportTicket;

use App\Models\InvoiceLabel;
use App\Models\SupportTicket;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketStatus;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SupportTicketList extends Component
{
    use WithPagination;

    #[Url()]
    public $search = '';

    public $perPage = 10;

    public $id;

    # Filter by Ticket Status
    #[Url()]
    public $filterByStatusTickets;

    # Filter by Ticket Priority
    #[Url()]
    public $filterByPriorityTickets;

    public function render()
    {
        $query = SupportTicket::query();

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
        // Filter records based on status
        if ($this->filterByStatusTickets) {
            $query->where('support_ticket_status_id', $this->filterByStatusTickets);
        }
        // Filter records based on status
        if ($this->filterByPriorityTickets) {
            $query->where('support_ticket_priority_id', $this->filterByPriorityTickets);
        }

        $supportTickets = $query->where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $getTicketStatuses = SupportTicketStatus::where('is_active', 1)->get();
        $getTicketPriorities = SupportTicketPriority::where('is_active', 1)->get();

        return view('livewire.user.support-ticket.support-ticket-list', [
            'supportTickets' => $supportTickets,
            'getTicketStatuses' => $getTicketStatuses,
            'getTicketPriorities' => $getTicketPriorities
        ]);
    }
}
