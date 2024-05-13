<div class="card" style="height: calc(100% - 15px)">
    <div class="card-body">
        <h4 class="card-title">Recent Support Tickets</h4>
        <div class="table-resposnive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket#</th>
                        <th>Status</th>
                        <th>Pririty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supportTickets as $ticket)
                        <tr wire:key="{{ $ticket->id }}">
                            <td>
                                <a href="{{ route('admin.support-tickets.show', $ticket->id) }}">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td>
                                <span class="badge"
                                    style="background-color:{{ $ticket->status->bg_color }};color:{{ $ticket->status->text_color }};">
                                    {{ $ticket->status->name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge"
                                    style="background-color:{{ $ticket->priority->bg_color }};color:{{ $ticket->priority->text_color }};">
                                    {{ $ticket->priority->name }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- /.table-resposnive --}}
    </div>
    {{-- /.card-body --}}
</div>
{{-- /.card --}}
