<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <ces class="fw-500 text-white">Room View Types</ces>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addViewType" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> Add New View Type
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search by View Type name."
                                wire:model="search" />

                            <button type="button" wire:click="searchVT" class="btn btn-primary mt-2">
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
                                    <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        View Type</th>

                                    <th class="text-secondary opacity-7"> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp



                                @forelse($infos as $index => $row)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">

                                                {{ $row->type_name }}
                                            </p>
                                        </td>

                                        <td>

                                            <a data-bs-toggle="modal" data-bs-target="#editVT"
                                                wire:click="edit({{ $row->id }})" type="button"
                                                class="badge badge-xs badge-warning fw-600 text-xs text-dark">
                                                Edit Info
                                            </a>

                                            <a href="#" class="badge badge-xs badge-danger fw-600 text-xs "
                                                wire:click.prevent="$dispatch('confirmDelete', {{ $row->id }})">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No view type items found!</td>
                                    </tr>
                                @endforelse



                            </tbody>
                        </table>
                        @if ($hasMore)
                            <div class="load-more-wrapper text-center mt-5">
                                <button wire:click="loadMore"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                                    Load More
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="addViewType" tabindex="-1" role="dialog"
        aria-labelledby="addViewType" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addViewType">Add View Type</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Type Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter View Type Name"
                                    wire:model="type_name">
                                @error('type_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading wire:target="store">
                                <i class="fas fa-spinner fa-spin me-2"></i> Saving...
                            </span>
                            <span wire:loading.remove wire:target="store">
                                Save
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div wire:ignore.self class="modal fade" id="editVT" tabindex="-1" role="dialog" aria-labelledby="editVT"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="editVT">Edit View Type</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Type Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="Enter View Type Name" wire:model="type_name">
                                @error('type_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>




                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                            wire:target="update">
                            <span wire:loading wire:target="update">
                                <i class="fas fa-spinner fa-spin me-2"></i> Saving...
                            </span>
                            <span wire:loading.remove wire:target="update">
                                Save
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>

<script>
    Livewire.on('confirmDelete', id => {
        if (confirm("Are you sure you want to delete this View Type? This action cannot be undone.")) {
            Livewire.dispatch('deleteVT', {
                id: id
            });
        }
    });
</script>
