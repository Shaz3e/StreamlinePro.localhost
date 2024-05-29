<div>
    <div class="row mb-3">
        <div class="col-md-1 col-sm-12 mb-2">
            <select wire:model.live="perPage" class="form-control form-control-sm form-control-border">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        {{-- /.col --}}
        <div class="col-md-2 col-sm-12">
            <select wire:model.live="filterByStatusTickets" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Ticket Status</option>
                @foreach ($getTicketStatuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 col-sm-12">
            <select wire:model.live="filterByPriorityTickets" class="form-control form-control-sm form-control-border">
                <option value="">Filter by Ticket Priority</option>
                @foreach ($getTicketPriorities as $priority)
                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 col-sm-12 mb-2">
            <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Search...">
        </div>
        {{-- .col --}}
        <div class="col-md-2 col-sm-12 mb-2">
            <div class="d-grid">
                <a href="{{ route('support-tickets.create') }}"
                    class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="ri-add-fill align-middle me-2"></i> Create
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10%">Ticket#</th>
                                    <th style="width: 60%">Ticket</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 10%">Priority</th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supportTickets as $ticket)
                                <tr wire:key="{{ $ticket->id }}">
                                    <td>
                                        <a class="text-black"
                                            href="{{ route('support-tickets.show', $ticket->id) }}">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <h6>
                                            <a class="text-black"
                                                href="{{ route('support-tickets.show', $ticket->id) }}">
                                                {{ $ticket->title }}
                                            </a>
                                        </h6>
                                        @if ($ticket->department_id)
                                            <span class="badge bg-dark">Department:
                                                {{ $ticket->department->name }}</span>
                                        @endif
                                        @if ($ticket->attachments > 0)
                                            <span class="badge bg-info">Attachments</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge"
                                            style="background-color: {{ $ticket->status->bg_color }}; color: {{ $ticket->status->text_color }}">
                                            {{ $ticket->status->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge"
                                            style="background-color: {{ $ticket->priority->bg_color }}; color: {{ $ticket->priority->text_color }}">
                                            {{ $ticket->priority->name }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('support-tickets.show', $ticket->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- /.table-responseive --}}
                    {{ $supportTickets->links() }}
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
</div>
