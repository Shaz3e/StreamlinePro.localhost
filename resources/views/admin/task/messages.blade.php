<section class="row">
    <div class="col-md-12">
        @foreach ($taskComments as $comment)
            <div class="card border border-success">
                <div class="card-header bg-transparent border-success">
                    <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Reply from
                        {{ $comment->postedBy->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        {!! $comment->message !!}
                    </div>

                    @if ($comment->attachments)
                        <div class="card-text">
                            <strong>Attachments</strong>
                            <ul>
                                @foreach (explode(',', $comment->attachments) as $attachment)
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
                    @endif
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <small><i class="ri-timer-2-line"></i> Replied at
                        {{ $comment->updated_at->format('l, F j, Y h:i A') }}</small>
                </div>
                {{-- /.card-footer --}}
            </div>
        @endforeach
    </div>
    {{-- /.col --}}
</section>
