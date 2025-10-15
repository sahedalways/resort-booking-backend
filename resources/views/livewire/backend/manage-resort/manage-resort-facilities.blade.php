<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">Resorts Facilities Management</h5>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#addFacility" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> Add New Facility
            </a>
        </div>

    </div>

    <div>


        <!-- Facilities Table -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header p-4">
                        <div class="row">
                            <div class="col-md-12" wire:ignore>
                                <input type="text" class="form-control" placeholder="Search by facility name..."
                                    wire:model="search" />
                                <button type="button" wire:click="searchFacility" class="btn btn-primary mt-2">
                                    Search
                                </button>
                            </div>
                        </div>
                        <div class="row mb-4 text-center">
                            <div class="col">
                                <h5 class="fw-500 text-dark">Resort: {{ $resort->name }}</h5>
                            </div>
                        </div>
                    </div>



                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs opacity-7">#</th>
                                        <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">Facility Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                            Services</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;

                                        $groupedFacilities = $resort->facilities->groupBy('facility_id');
                                    @endphp

                                    @forelse ($groupedFacilities as $facilityId => $services)
                                        <tr class="align-middle">
                                            <td>{{ $i++ }}</td>

                                            <td>
                                                @if ($services->first()->facility)
                                                    <p class="text-sm font-weight-bold mb-5">
                                                        <i class="{{ $services->first()->facility->icon }}"></i>
                                                        {{ $services->first()->facility->name }}
                                                    </p>
                                                @else
                                                    <span class="text-muted">No Facility</span>
                                                @endif
                                            </td>


                                            <td>
                                                <div class="d-flex flex-wrap gap-3 mb-3">
                                                    @foreach ($services as $service)
                                                        <span
                                                            class="badge rounded-pill bg-gradient-info text-white px-3 py-2 d-flex align-items-center shadow-sm position-relative">
                                                            @if ($service->icon)
                                                                <i class="{{ $service->icon }} me-1 text-white"></i>
                                                            @endif
                                                            {{ $service->type_name }}


                                                            <button type="button"
                                                                class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle p-1 rounded-circle shadow-sm"
                                                                style="font-size: 0.65rem; line-height: 0; width: 18px; height: 18px;"
                                                                wire:click.prevent="deleteService({{ $facilityId }}, '{{ $service->type_name }}')"
                                                                title="Delete service">
                                                                &times;
                                                            </button>
                                                        </span>
                                                    @endforeach
                                                </div>

                                                <!-- Add New Service Button -->
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#addServiceModal"
                                                    wire:click="addNewService({{ $facilityId }})">
                                                    <i class="fa fa-plus me-1"></i> Add Service
                                                </button>
                                            </td>

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center text-muted">No Facilities Found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>



                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="addFacility" tabindex="-1" role="dialog"
        aria-labelledby="addFacility" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600"> Add New Facility</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Select Facility <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" wire:model="selectedFacilityId"
                                    wire:change="loadFacilityServices">
                                    <option value="">-- Select Facility --</option>
                                    @foreach ($facilities as $facility)
                                        <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                    @endforeach
                                </select>

                                @error('selectedFacilityId')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
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




    <div wire:ignore.self class="modal fade" id="addServiceModal" tabindex="-1" role="dialog"
        aria-labelledby="addServiceModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600"> Add Service</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="saveService">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">



                            <!-- Service Name input -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Service Name <span
                                        class="text-danger">*</span></label>
                                <input required type="text" class="form-control" placeholder="Enter service name"
                                    wire:model.defer="service_name">
                                @error('service_name')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Icon <span class="text-danger">*</span></label>
                                <input required type="text" class="form-control"
                                    placeholder="FontAwesome icon, e.g. fas fa-wifi" wire:model.defer="icon">
                                @error('icon')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                            wire:target="saveService">
                            <span wire:loading wire:target="saveService">
                                <i class="fas fa-spinner fa-spin me-2"></i> Saving...
                            </span>
                            <span wire:loading.remove wire:target="saveService">
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
        if (confirm("Are you sure you want to delete this resort facility? This action cannot be undone.")) {
            Livewire.dispatch('deleteItem', {
                id: id
            });
        }
    });
</script>
