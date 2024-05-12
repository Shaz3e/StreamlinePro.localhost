<div class="card" wire:poll.5s.visible style="height: calc(100% - 15px)">
    <div class="card-header">
        <h4 class="card-title">Recent Invoice</h4>
    </div>
    <div class="card-body">
        @foreach ($invoices as $invoice)
            <div class="card-title">
                
                <a href="{{ route('admin.invoices.show', $invoice->id) }}">Invoice# {{ $invoice->id }}</a>
                To:
                    @if ($invoice->user)
                        <a href="{{ route('admin.users.show', $invoice->user->id) }}">
                             {{ $invoice->user->name }}
                        </a>
                    @endif
                    @if ($invoice->company)
                        <a href="{{ route('admin.companies.show', $invoice->company->id) }}">
                           {{ $invoice->company->name }}
                        </a>
                    @endif
                
                    <span class="badge"
                        style="background-color: {{ $invoice->label->bg_color }};color: {{ $invoice->label->text_color }}">
                        {{ $invoice->status }}
                    </span>
                Amount: {{ $invoice->total }}
            </div>
            <hr />
        @endforeach
    </div>
    {{-- /.card-body --}}
</div>
{{-- /.card --}}
