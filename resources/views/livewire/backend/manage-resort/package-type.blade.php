<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <ces class="fw-500 text-white">Resort Package Types</ces>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addPackageType" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> Add New Package Type
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search by package type name."
                                wire:model="search" />

                            <button type="button" wire:click="searchPT" class="btn btn-primary mt-2">
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
                                        Package Type</th>

                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Is Refundable</th>

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
                                                {!! fa_icon($row->icon) !!}
                                                {{ $row->type_name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ getRefundableText($row->is_refundable) }}
                                            </p>
                                        </td>
                                        <td>

                                            <a data-bs-toggle="modal" data-bs-target="#editPT"
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
                                        <td colspan="4">No package types found</td>
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


    <div wire:ignore.self class="modal fade" id="addPackageType" tabindex="-1" role="dialog"
        aria-labelledby="addPackageType" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addPackageType">Add Service Type</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Type Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="Enter Service Type Name" wire:model="type_name">
                                @error('type_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="col-md-12 mb-2">
                                <label class="form-label">Icon <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="Enter FontAwesome icon, e.g. fas fa-wifi" wire:model="icon">
                                <small class="text-muted">Use any FontAwesome 5/6 class, e.g. <code>fas fa-wifi</code>,
                                    <code>fas fa-bath</code></small>
                                @error('icon')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="col-md-12 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_refundable"
                                        wire:model="is_refundable">
                                    <label class="form-check-label" for="is_refundable">
                                        Is Refundable
                                    </label>
                                </div>
                                @error('is_refundable')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                            wire:target="store">
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

    <div wire:ignore.self class="modal fade" id="editPT" tabindex="-1" role="dialog" aria-labelledby="editPT"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="editPT">Edit Service Type</h6>
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
                                    placeholder="Enter Service Type Name" wire:model="type_name">
                                @error('type_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="col-md-12 mb-2">
                                <label class="form-label">Icon <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control"
                                    placeholder="Enter FontAwesome icon, e.g. fas fa-wifi" wire:model="icon">
                                <small class="text-muted">Use any FontAwesome 5/6 class, e.g. <code>fas fa-wifi</code>,
                                    <code>fas fa-bath</code></small>


                                <p class="text-sm font-weight-bold mb-0">
                                    {!! fa_icon($old_icon) !!}

                                </p>
                                @error('icon')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-12 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_refundable"
                                        wire:model="is_refundable">
                                    <label class="form-check-label" for="is_refundable">
                                        Is Refundable
                                    </label>
                                </div>
                                @error('is_refundable')
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
        if (confirm("Are you sure you want to delete this package Type? This action cannot be undone.")) {
            Livewire.dispatch('deletePT', {
                id: id
            });
        }
    });
</script>
