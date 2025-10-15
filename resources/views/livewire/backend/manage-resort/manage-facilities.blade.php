<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <ces class="fw-500 text-white">Resort & Room Facilities</ces>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addFacility" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> Add New Facility
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search by facility name."
                                wire:model="search" />

                            <button type="button" wire:click="searchFacility" class="btn btn-primary mt-2">
                                Search
                            </button>
                        </div>

                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Facility Name</th>

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
                                                {{ $row->name }}
                                            </p>
                                        </td>

                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#editItem"
                                                wire:click="edit({{ $row->id }})" type="button"
                                                class="badge badge-xs badge-warning fw-600 text-xs text-dark">
                                                Edit Info
                                            </a>

                                            <a data-bs-toggle="modal" data-bs-target="#manageFacilityOptions"
                                                wire:click="manageFacilityOptions({{ $row->id }})" type="button"
                                                class="badge badge-xs badge-success fw-600 text-xs text-dark">
                                                Manage Options
                                            </a>

                                            <a href="#" class="badge badge-xs badge-danger fw-600 text-xs"
                                                wire:click.prevent="$dispatch('confirmDelete', {{ $row->id }})">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No facilities found!</td>
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


    <div wire:ignore.self class="modal fade" id="addFacility" tabindex="-1" role="dialog"
        aria-labelledby="addFacility" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addFacility">Add Facility</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter Name"
                                    wire:model="name">
                                @error('name')
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

    <div wire:ignore.self class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="editItem"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="editItem">Edit Facility</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <div class="col-md-12 mb-2">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter Name"
                                    wire:model="name">
                                @error('name')
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



    <div wire:ignore.self class="modal fade" id="manageFacilityOptions" tabindex="-1" role="dialog"
        aria-labelledby="manageFacilityOptions" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document"><!-- ✅ Added modal-lg -->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600"> Manage Facility Options</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="saveOptions">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            @foreach ($optionInputs as $index)
                                <div class="row mb-2" wire:key="option-{{ $index }}">
                                    <div class="col-md-10">
                                        <select class="form-control" wire:model="options.{{ $index }}"
                                            required>
                                            <option value="">-- Select Service Type --</option>
                                            @foreach ($serviceTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                            @endforeach
                                        </select>

                                        @error("options.$index")
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>



                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger w-100"
                                            wire:click.prevent="removeOptionInput({{ $index }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>



                                </div>
                            @endforeach

                            <div class="col-12 mt-2">
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click.prevent="addOptionInput">
                                    + Add Another Option
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <div class="">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="saveOptions">
                                <span wire:loading wire:target="saveOptions">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Saving...
                                </span>
                                <span wire:loading.remove wire:target="saveOptions">
                                    Save
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>



</div>

<script>
    Livewire.on('confirmDelete', id => {
        if (confirm("Are you sure you want to delete this facility item? This action cannot be undone.")) {
            Livewire.dispatch('deleteItem', {
                id: id
            });
        }
    });
</script>
