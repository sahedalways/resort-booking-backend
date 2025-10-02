<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">Payments</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search payments..."
                                wire:model="search" />
                            <button type="button" wire:click="searchPayment" class="btn btn-primary mt-2">
                                Search
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Resort</th>
                                    <th>Room</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Method</th>
                                    <th>Txn ID</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @forelse($infos as $row)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            {{ optional($row->user)->f_name }} {{ optional($row->user)->l_name }}
                                        </td>
                                        <td>{{ optional($row->booking->resort)->name }}</td>
                                        <td>{{ optional($row->booking->room)->name }}</td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
                                        <td>{{ $row->currency }}</td>
                                        <td>{{ $row->payment_method }}</td>
                                        <td>{{ $row->transaction_id }}</td>
                                        <td>{!! paymentStatusBadge($row->status) !!}</td>

                                        <td>{{ $row->notes ?? '-' }}</td>
                                        <td>{{ $row->created_at?->format('d M, Y h:i A') }}</td>

                                        <td>
                                            <a href="#" class="badge badge-xs badge-danger fw-600 text-xs"
                                                wire:click.prevent="$dispatch('confirmDelete', {{ $row->id }})">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No payments found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($hasMore)
                            <div class="text-center mt-4">
                                <button wire:click="loadMore"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-4 py-2">
                                    Load More
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    Livewire.on('confirmDelete', id => {
        if (confirm("Are you sure you want to delete this payment? This action cannot be undone.")) {
            Livewire.dispatch('deletePaymentItem', {
                id: id
            });
        }
    });
</script>

<script>
    Livewire.on('confirmDelete', id => {
        if (confirm("Are you sure you want to delete this payment? This action cannot be undone.")) {
            Livewire.dispatch('deletePaymentItem', {
                id: id
            });
        }
    });
</script>
