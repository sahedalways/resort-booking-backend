<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">
                Booking Info - {{ ucfirst($status) }}
            </h5>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Search booking info..."
                                wire:model="search" />
                            <button type="button" wire:click="searchBooking" class="btn btn-primary mt-2">
                                Search
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Resort</th>
                                            <th>Room / Package</th>
                                            <th>Amount</th>
                                            <th>Check-In Date</th>
                                            <th>Check-Out Date</th>
                                            <th>Booking Created</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($infos as $index => $row)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    {{ optional($row->user)->f_name }}
                                                    {{ optional($row->user)->l_name }}<br>
                                                    <small class="text-muted">{{ optional($row->user)->email }}</small>
                                                </td>
                                                <td>{{ optional($row->resort)->name }}</td>
                                                <td>{{ optional($row->room)->name }}</td>
                                                <td>{{ $row->amount }} {{ $row->currency ?? 'BDT' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->start_date)->format('d M, Y') }}</td>
                                                <td>
                                                    {{ $row->room->name === 'Day Long' ? 'N/A' : \Carbon\Carbon::parse($row->created_at)->format('d M, Y h:i A') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M, Y h:i A') }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge 
                            @if ($row->status == 'pending') bg-warning
                            @elseif($row->status == 'confirmed') bg-success
                            @elseif($row->status == 'cancelled') bg-danger
                            @elseif($row->status == 'completed') bg-primary
                            @else bg-secondary @endif
                            text-white px-2 py-1">
                                                        {{ ucfirst($row->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column gap-1">
                                                        <a href="#"
                                                            wire:click.prevent="toggleRow({{ $row->id }})"
                                                            class="btn btn-info btn-sm w-100">
                                                            {{ isset($expandedRows[$row->id]) ? 'Hide' : 'View' }}
                                                            Details
                                                        </a>

                                                        <a href="#"
                                                            wire:click.prevent="$dispatch('confirmDelete', {{ $row->id }})"
                                                            class="btn btn-danger btn-sm w-100">Delete</a>

                                                        @if ($row->status === 'pending')
                                                            <a href="#"
                                                                wire:click.prevent="confirmBooking({{ $row->id }})"
                                                                class="btn btn-success btn-sm w-100">Confirm</a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            @if (isset($expandedRows[$row->id]))
                                                <tr class="table-light text-start">
                                                    <td colspan="10" class="p-3">
                                                        <div
                                                            class="d-flex flex-column flex-md-row justify-content-between gap-4">
                                                            <!-- Booking Details -->
                                                            <div
                                                                class="p-3 border rounded shadow-sm bg-white flex-fill">
                                                                <h6 class="text-primary mb-3">
                                                                    <i class="bi bi-person-fill me-2"></i>Booking
                                                                    Details
                                                                </h6>
                                                                <p class="mb-2"><strong>Booking For:</strong>
                                                                    {{ $row->booking_for === 'me' ? 'Self' : $row->booking_for }}
                                                                </p>
                                                                <p class="mb-2"><strong>Adult Guests:</strong>
                                                                    {{ $row->adult }}</p>
                                                                <p class="mb-2"><strong>Child Guests:</strong>
                                                                    {{ $row->child }}</p>
                                                                <p class="mb-2"><strong>Comments:</strong>
                                                                    {{ $row->comment ?? 'N/A' }}</p>
                                                            </div>

                                                            <!-- Payment Info -->
                                                            <div
                                                                class="p-3 border rounded shadow-sm bg-white flex-fill">
                                                                <h6 class="text-success mb-3">
                                                                    <i class="bi bi-currency-dollar me-2"></i>Payment
                                                                    Info
                                                                </h6>
                                                                <p class="mb-2"><strong>Coupon Used:</strong>
                                                                    {{ $row->is_used_coupon ? 'Yes' : 'No' }}
                                                                    {{ $row->coupon_code ? '(' . $row->coupon_code . ')' : '' }}
                                                                </p>
                                                                <p class="mb-2"><strong>Grand Total:</strong>
                                                                    <span class="fw-bold">{{ $row->amount }}
                                                                        {{ $row->currency ?? 'BDT' }}</span>
                                                                </p>
                                                                <p class="mb-2"><strong>Check-In:</strong>
                                                                    {{ \Carbon\Carbon::parse($row->start_date)->format('d M, Y') }}
                                                                </p>
                                                                <p class="mb-2"><strong>Check-Out:</strong>
                                                                    {{ $row->room->name === 'Day Long' ? 'N/A' : \Carbon\Carbon::parse($row->created_at)->format('d M, Y h:i A') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center">No bookings found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

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

        <script>
            Livewire.on('confirmDelete', id => {
                if (confirm("Are you sure you want to delete this booking info? This action cannot be undone.")) {
                    Livewire.dispatch('deleteItem', {
                        id: id
                    });
                }
            });
        </script>
