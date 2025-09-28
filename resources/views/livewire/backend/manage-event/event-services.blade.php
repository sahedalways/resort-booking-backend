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

                                @foreach ($eventServices as $row)
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
                                                class="badge badge-xs badge-warning fw-600 text-xs">
                                                Edit Info
                                            </a>

                                            <a href="#" class="badge badge-xs badge-danger fw-600 text-xs"
                                                wire:click.prevent="$dispatch('confirmDelete', {{ $row->id }})">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($hasMorePages)
                            <div x-data="{
                                init() {
                                    let observer = new IntersectionObserver((entries) => {
                                        entries.forEach(entry => {
                                            if (entry.isIntersecting) {
                                                @this.call('loadServices')
                                                console.log('loading...')
                                            }
                                        })
                                    }, {
                                        root: null
                                    });
                                    observer.observe(this.$el);
                                }
                            }"
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4">
                                <div class="text-center pb-2 d-flex justify-content-center align-items-center">
                                    Loading...
                                    <div class="spinner-grow d-inline-flex mx-2 text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="addService"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addService">Add Event Service</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                            <!-- Thumbnail -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Thumbnail Image <span class="text-danger">*</span></label>
                                <input type="file" required class="form-control" wire:model="thumbnail">

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

                            <!-- Description -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" wire:model="description" rows="3" placeholder="Optional description"></textarea>
                                @error('description')
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





    {{-- <div wire:ignore.self class="modal fade" id="edituser" tabindex="-1" role="dialog"
        aria-labelledby="edituser" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="edituser">Edit User</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form>
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">


                            <!-- First Name -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter First Name"
                                    wire:model="first_name">
                                @error('first_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Last Name"
                                    wire:model="last_name">
                                @error('last_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Enter Email Address"
                                    wire:model="email">
                                @error('email')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Phone Number"
                                    wire:model="phone_no">
                                @error('phone_no')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password (Optional in Edit) -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Password (Leave blank if not changing)</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Enter New Password"
                                        wire:model="password" id="edit_password">
                                    <span class="input-group-text" onclick="togglePassword('edit_password')">
                                        <i id="edit-password-icon" class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-12 mb-1">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                        wire:model="password_confirmation" id="edit_password_confirmation">
                                    <span class="input-group-text"
                                        onclick="togglePassword('edit_password_confirmation')">
                                        <i id="edit-confirm-password-icon" class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-12 mb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="edit_is_active"
                                        wire:model="is_active">
                                    <label class="form-check-label" for="edit_is_active">Is Active ?</label>
                                </div>
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
    </div> --}}



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
