<section class="row">
    <div class="col-md-12">
        @foreach ($supportTicketReplies as $reply)
            @if ($reply->client_reply_by !== null)
                <div class="card border border-danger">
                    <div class="card-header bg-transparent border-danger">
                        <h5 class="my-0 text-danger"><i class="mdi mdi-check-all me-3"></i>Client Reply</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $reply->client->name }}</h5>
                        <div class="card-text">
                            {!! $reply->message !!}
                        </div>
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <small>Last Updated On {{ $reply->updated_at->format('l, F j, Y h:i A') }}</small>
                    </div>
                    {{-- /.card-footer --}}
                </div>
            @endif
            @if ($reply->staff_reply_by !== null)
                <div class="card border border-success">
                    <div class="card-header bg-transparent border-success">
                        <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Staff Reply</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $reply->staff->name }}</h5>
                        <div class="card-text">
                            {!! $reply->message !!}
                        </div>
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <small>Last Updated On {{ $reply->updated_at->format('l, F j, Y h:i A') }}</small>
                    </div>
                    {{-- /.card-footer --}}
                </div>
            @endif
        @endforeach
    </div>
    {{-- /.col --}}
</section>
