<div class="card" style="height: calc(100% - 15px)">
    <div class="card-body">
        <h4 class="card-title">Recent Support Ticket Replies</h4>
        <div class="table-resposnive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket#</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Last Reply</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supportTicketReplies as $reply)
                        <tr wire:key="{{ $reply->id }}">
                            <td>
                                <a href="{{ route('admin.support-tickets.show', $reply->support_ticket_id) }}">
                                    {{ $reply->supportTicket->ticket_number }}
                                </a>
                            </td>
                            <td>
                                <span class="badge"
                                    style="background-color:{{ $reply->supportTicket->status->bg_color }};color:{{ $reply->supportTicket->status->text_color }};">
                                    {{ $reply->supportTicket->status->name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge"
                                    style="background-color:{{ $reply->supportTicket->priority->bg_color }};color:{{ $reply->supportTicket->priority->text_color }};">
                                    {{ $reply->supportTicket->priority->name }}
                                </span>
                            </td>
                            <td>
                                @if ($reply->client_reply_by)
                                    {{ $reply->client->name }}
                                @endif
                                @if ($reply->staff_reply_by)
                                    {{ $reply->staff->name }}
                                @endif
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
