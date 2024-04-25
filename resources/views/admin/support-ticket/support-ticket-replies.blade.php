<section class="row">
    <div class="col-md-12">
        @foreach ($supportTicketReplies as $reply)
            @if ($reply->client_reply_by !== null)
                <div class="card border border-danger">
                    <div class="card-header bg-transparent border-danger">
                        <h5 class="my-0 text-danger"><i class="mdi mdi-check-all me-3"></i>Client Reply</h5>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            {!! $reply->message !!}
                        </div>

                        <div class="card-text">
                            <strong>Attachments</strong>
                            <ul>
                                @foreach (explode(',', $reply->attachments) as $attachment)
                                    <li>
                                        <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="">
                                            Open
                                        </a>
                                        <a href="{{ asset('storage/' . $attachment) }}" download="{{ $attachment }}"
                                            class="">
                                            Download
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        {{-- /.card-text --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <small><i class="ri-timer-2-line"></i> Replied at {{ $reply->updated_at->format('l, F j, Y h:i A') }}</small>
                    </div>
                    {{-- /.card-footer --}}
                </div>
            @endif
            @if ($reply->staff_reply_by !== null)
                <div class="card border border-success">
                    <div class="card-header bg-transparent border-success">
                        <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>
                            Staff Reply
                            <span class="badge bg-success">{{ $reply->staff->name }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            {!! $reply->message !!}
                        </div>

                        <div class="card-text">
                            <strong>Attachments</strong>
                            <ul>
                                @foreach (explode(',', $reply->attachments) as $attachment)
                                    <li>
                                        <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="">
                                            Open
                                        </a>
                                        <a href="{{ asset('storage/' . $attachment) }}" download="{{ $attachment }}"
                                            class="">
                                            Download
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        {{-- /.card-text --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <small><i class="ri-timer-2-line"></i> Replied at {{ $reply->updated_at->format('l, F j, Y h:i A') }}</small>
                    </div>
                    {{-- /.card-footer --}}
                </div>
            @endif
        @endforeach
    </div>
    {{-- /.col --}}
</section>
