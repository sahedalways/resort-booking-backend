<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <ces class="fw-500 text-white">Event Services</ces>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addService" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> Add New Service
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search by service title."
                                wire:model="search" />

                            <button type="button" wire:click="searchService" class="btn btn-primary mt-2">
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
                                        Title</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Description</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">
                                        Thumbnail</th>

                                    <th class="text-secondary opacity-7"> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp

                                @forelse($infos as $index => $row)
                                    <tr>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{ $i++ }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $row->title }}</p>
                                        </td>

                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ \Illuminate\Support\Str::limit($row->description, 55, '...') }}
                                            </p>
                                        </td>


                                        <td>
                                            <img src="{{ getFileUrl($row->thumbnail) }}" alt="Event Service Thumbnail"
                                                class="img-thumbnail" width="100">
                                        </td>



                                        <td>

                                            <a data-bs-toggle="modal" data-bs-target="#editService"
                                                wire:click="edit({{ $row->id }})" type="button"
                                                class="badge badge-xs badge-warning fw-600 text-xs text-dark">
                                                Edit Info
                                            </a>



                                            <a data-bs-toggle="modal" data-bs-target="#addServiceImages"
                                                wire:click="addServiceImages({{ $row->id }})" type="button"
                                                class="badge badge-xs badge-success fw-600 text-xs text-dark">
                                                Manage Image Gallery
                                            </a>

                                            <a href="#" class="badge badge-xs badge-danger fw-600 text-xs "
                                                wire:click.prevent="$dispatch('confirmDelete', {{ $row->id }})">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No event services found!</td>
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


    <div wire:ignore.self class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="addService"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addService">Add Event Service</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <!-- Service Title -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter Service Title"
                                    wire:model="title">
                                @error('title')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <!-- Description -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Description </label>
                                <textarea class="form-control" wire:model="description" rows="3" placeholder="Enter description"></textarea>
                                @error('description')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <!-- Thumbnail -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Thumbnail Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" wire:model="thumbnail" accept="image/*">

                                <div class="mt-2">
                                    @if ($thumbnail)
                                        <img src="{{ $thumbnail->temporaryUrl() }}" class="img-thumbnail"
                                            width="120">
                                    @else
                                        <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                            width="120" alt="No Logo">
                                    @endif
                                </div>

                                @error('thumbnail')
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





    <div wire:ignore.self class="modal fade" id="editService" tabindex="-1" role="dialog"
        aria-labelledby="editService" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="editService">Edit Event Service</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <!-- Service Title -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter Service Title"
                                    wire:model="title">
                                @error('title')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Description -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Description </label>
                                <textarea class="form-control" wire:model="description" rows="3" placeholder="Enter description"></textarea>
                                @error('description')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Thumbnail -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Thumbnail Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" wire:model="thumbnail" accept="image/*">

                                <div class="mt-2">
                                    @if ($thumbnail)
                                        <img src="{{ $thumbnail->temporaryUrl() }}" class="img-thumbnail"
                                            width="120">
                                    @elseif ($old_thumbnail)
                                        <img src="{{ getFileUrl($old_thumbnail) }}" class="img-thumbnail"
                                            width="120">
                                    @else
                                        <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                            width="120" alt="No Logo">
                                    @endif
                                </div>

                                @error('thumbnail')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <div class="">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="update">
                                <span wire:loading wire:target="update">
                                    <i class="fas fa-spinner fa-spin me-2"></i> updating...
                                </span>
                                <span wire:loading.remove wire:target="update">
                                    Update
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>



    <div wire:ignore.self class="modal fade" id="addServiceImages" tabindex="-1" role="dialog"
        aria-labelledby="addServiceImages" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">Manage Image Gallery</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>



                </div>

                <form wire:submit.prevent="saveImages">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">
                            @foreach ($imageInputs as $index)
                                <div class="row mb-2" wire:key="image-{{ $index }}">
                                    <div class="col-md-8">
                                        <input type="file" wire:model="images.{{ $index }}"
                                            class="form-control me-2" accept="image/*">


                                    </div>

                                    <div class="col-md-2">
                                        @if (isset($images[$index]))
                                            @if (!is_string($images[$index]))
                                                <img src="{{ $images[$index]->temporaryUrl() }}"
                                                    class="img-thumbnail" width="80">
                                            @elseif (is_string($images[$index]))
                                                <!-- Saved image -->
                                                <img src="{{ asset(getFileUrl($images[$index])) }}"
                                                    class="img-thumbnail" width="80">
                                            @endif
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger w-100"
                                            wire:click.prevent="removeImageInput({{ $index }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>




                                    @error("images.$index")
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="col-12 mt-2">
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click.prevent="addImageInput">
                                    + Add Another Image
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <div class="">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="saveImages">
                                <span wire:loading wire:target="saveImages">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Saving...
                                </span>
                                <span wire:loading.remove wire:target="saveImages">
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
        if (confirm("Are you sure you want to delete this service? This action cannot be undone.")) {
            Livewire.dispatch('deleteService', {
                id: id
            });
        }
    });
</script>
