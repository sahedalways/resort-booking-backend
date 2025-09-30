<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <ces class="fw-500 text-white">Resorts Management</ces>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addResort" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> Add New Resort
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search by resort name."
                                wire:model="search" />

                            <button type="button" wire:click="searchResort" class="btn btn-primary mt-2">
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
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Description</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Location</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Distance</th>
                                    {{-- <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Day CheckIn</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Day CheckOut</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Night CheckIn</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Night CheckOut</th> --}}

                                    <th class="text-secondary opacity-7"> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp

                                @foreach ($items as $row)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">

                                                {{ $row->name }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ shortText($row->desc) }}
                                            </p>
                                        </td>


                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">

                                                {{ $row->location }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">

                                                {{ $row->distance }} KM
                                            </p>
                                        </td>

                                        {{-- <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $row->d_check_in ? \Carbon\Carbon::createFromFormat('H:i:s', $row->d_check_in)->format('h:i A') : 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $row->d_check_out ? \Carbon\Carbon::createFromFormat('H:i:s', $row->d_check_out)->format('h:i A') : 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $row->n_check_in ? \Carbon\Carbon::createFromFormat('H:i:s', $row->n_check_in)->format('h:i A') : 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $row->n_check_out ? \Carbon\Carbon::createFromFormat('H:i:s', $row->n_check_out)->format('h:i A') : 'N/A' }}
                                            </p>
                                        </td> --}}


                                        <td>
                                            <!-- Manage Images -->
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#manageImages"
                                                wire:click="addResortImages({{ $row->id }})" style="color: #000;"
                                                class="badge badge-xs badge-primary fw-600 text-xs">
                                                Manage Images
                                            </a>

                                            <!-- Manage Services -->
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#manageServices"
                                                wire:click="manageServices({{ $row->id }})"
                                                class="badge badge-xs badge-info fw-600 text-xs" style="color: #000;"
                                                onmouseover="this.style.color='#fff'"
                                                onmouseout="this.style.color='#000'">
                                                Manage Services
                                            </a>




                                            <!-- Manage Additional Facts -->
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#manageAdditionalFacts"
                                                wire:click="manageFactOptions({{ $row->id }})"
                                                class="badge badge-xs badge-secondary fw-600 text-xs"
                                                style="color: #000;" onmouseover="this.style.color='#fff'"
                                                onmouseout="this.style.color='#000'">
                                                Manage Additional Facts
                                            </a>


                                            <!-- Manage Facilities -->
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#manageFacilities"
                                                wire:click="manageFacilities({{ $row->id }})" style="color: #000;"
                                                class="badge badge-xs badge-dark fw-600 text-xs">
                                                Manage Facilities
                                            </a>

                                            <!-- View Details -->
                                            <a href="#" class="badge badge-xs fw-600 text-xs"
                                                style="background-color: #5acaa3; color: #000; text-decoration: none; transition: 0.3s;"
                                                onmouseover="this.style.backgroundColor='#3aa57a'; this.style.color='#fff';"
                                                onmouseout="this.style.backgroundColor='#5acaa3'; this.style.color='#000';">
                                                View Details
                                            </a>





                                            <a data-bs-toggle="modal" data-bs-target="#editItem"
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
                                @endforeach
                            </tbody>
                        </table>
                        @if ($hasMorePages)
                            <div x-data="{
                                init() {
                                    let observer = new IntersectionObserver((entries) => {
                                        entries.forEach(entry => {
                                            if (entry.isIntersecting) {
                                                @this.call('loadResortData')
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


    <div wire:ignore.self class="modal fade" id="addResort" tabindex="-1" role="dialog" aria-labelledby="addResort"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="addResort">Add Resort</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            {{-- Name --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Name"
                                    wire:model="name" required>
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Distance --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Distance (KM) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control"
                                    placeholder="Enter Distance" wire:model="distance" required>
                                @error('distance')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Location"
                                    wire:model="location" required>
                                @error('location')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" placeholder="Enter Description" wire:model="desc" required></textarea>
                                @error('desc')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-12 mb-2">
                                <label class="form-label">Package Type <span class="text-danger">*</span></label>
                                <select class="form-control" wire:model="packageTypeId" required>
                                    <option value="">-- Select Package Type --</option>
                                    @foreach ($packageTypes as $type)
                                        <option value="{{ $type->id }}">
                                            {!! fa_icon($type->icon) !!} {{ $type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('packageTypeId')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            {{-- Day Check In --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Day Check-In </label>
                                <input type="time" class="form-control" wire:model="d_check_in">
                                @error('d_check_in')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Day Check Out --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Day Check-Out </label>
                                <input type="time" class="form-control" wire:model="d_check_out">
                                @error('d_check_out')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Night Check In --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Night Check-In </label>
                                <input type="time" class="form-control" wire:model="n_check_in">
                                @error('n_check_in')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Night Check Out --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Night Check-Out </label>
                                <input type="time" class="form-control" wire:model="n_check_out">
                                @error('n_check_out')
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


    <div wire:ignore.self class="modal fade" id="editItem" tabindex="-1" role="dialog"
        aria-labelledby="editItem" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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

                            {{-- Name --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Name"
                                    wire:model="name" required>
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Distance --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Distance (KM) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control"
                                    placeholder="Enter Distance" wire:model="distance" required>
                                @error('distance')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Location --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Location"
                                    wire:model="location" required>
                                @error('location')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" placeholder="Enter Description" wire:model="desc" required></textarea>
                                @error('desc')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-12 mb-2">
                                <label class="form-label">Package Type <span class="text-danger">*</span></label>
                                <select class="form-control" wire:model="packageTypeId" required>
                                    <option value="">-- Select Package Type --</option>
                                    @foreach ($packageTypes as $type)
                                        <option value="{{ $type->id }}"
                                            @if ($packageTypeId == $type->id) selected @endif>

                                            {!! fa_icon($type->icon) !!} {{ $type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('packageTypeId')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Day Check In --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Day Check-In </label>
                                <input type="time" class="form-control" wire:model="d_check_in">
                                @error('d_check_in')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Day Check Out --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Day Check-Out </label>
                                <input type="time" class="form-control" wire:model="d_check_out">
                                @error('d_check_out')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Night Check In --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Night Check-In </label>
                                <input type="time" class="form-control" wire:model="n_check_in">
                                @error('n_check_in')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Night Check Out --}}
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Night Check-Out </label>
                                <input type="time" class="form-control" wire:model="n_check_out">
                                @error('n_check_out')
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



    <div wire:ignore.self class="modal fade" id="manageImages" tabindex="-1" role="dialog"
        aria-labelledby="manageImages" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                                <div class="col-md-12 mb-2 d-flex align-items-center"
                                    wire:key="image-{{ $index }}">
                                    <input type="file" wire:model="images.{{ $index }}"
                                        class="form-control me-2" accept="image/*">

                                    @if (isset($images[$index]))
                                        @if (!is_string($images[$index]))
                                            <img src="{{ $images[$index]->temporaryUrl() }}" class="img-thumbnail"
                                                width="80">
                                        @elseif (is_string($images[$index]))
                                            <!-- Saved image -->
                                            <img src="{{ asset(getFileUrl($images[$index])) }}" class="img-thumbnail"
                                                width="80">
                                        @endif
                                    @endif



                                    <button type="button" class="btn btn-sm btn-danger ms-2 p-1"
                                        wire:click.prevent="removeImageInput({{ $index }})"
                                        style="line-height: 1;">
                                        <i class="fas fa-times" style="font-size: 0.75rem;"></i>
                                    </button>


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



    <div wire:ignore.self class="modal fade" id="manageAdditionalFacts" tabindex="-1" role="dialog"
        aria-labelledby="manageAdditionalFacts" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600"> Manage Additional Facts</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="saveFactOptions">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            @foreach ($factOptionInputs as $index)
                                <div class="col-md-12 mb-2 d-flex align-items-center"
                                    wire:key="factOption-{{ $index }}">

                                    <div class="flex-grow-1">
                                        <input type="text" required class="form-control"
                                            placeholder="Enter add. fact Name"
                                            wire:model="factOptions.{{ $index }}">
                                        @error("factOptions.$index")
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <button type="button" class="btn btn-sm btn-danger ms-2 p-1"
                                        wire:click.prevent="removeFactOptionInput({{ $index }})"
                                        style="line-height: 1;">
                                        <i class="fas fa-times" style="font-size: 0.75rem;"></i>
                                    </button>
                                </div>
                            @endforeach

                            <div class="col-12 mt-2">
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click.prevent="addFactOptionInput">
                                    + Add Another Fact
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <div class="">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="saveFactOptions">
                                <span wire:loading wire:target="saveFactOptions">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Saving...
                                </span>
                                <span wire:loading.remove wire:target="saveFactOptions">
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
        if (confirm("Are you sure you want to delete this resort? This action cannot be undone.")) {
            Livewire.dispatch('deleteItem', {
                id: id
            });
        }
    });
</script>
