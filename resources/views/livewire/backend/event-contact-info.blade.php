<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">Event Contact Info</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search contacts..."
                                wire:model="search" />
                            <button type="button" wire:click="searchContact" class="btn btn-primary mt-2">
                                Search
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date of Function</th>
                                    <th>Gathering Size</th>
                                    <th>Preferred Location</th>
                                    <th>Budget</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @forelse($infos as $row)
                                    <tr class="{{ !$row->is_read ? 'table-warning fw-bold' : '' }}">
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td>{{ $row->date_of_function }}</td>
                                        <td>{{ $row->gathering_size }}</td>
                                        <td>{{ $row->preferred_location }}</td>
                                        <td>{{ $row->budget }}</td>
                                        <td>{{ $row->message ?? '-' }}</td>
                                        <td>{{ $row->created_at?->format('d M, Y h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No contacts found!</td>
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
