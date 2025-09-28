<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">Event Hero Settings</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form class="row g-3" wire:submit.prevent="save">

                        <!-- Title -->
                        <div class="col-6">
                            <label class="form-label">Hero Title</label>
                            <input type="text" class="form-control" placeholder="Enter Hero Title"
                                wire:model="title">

                            @error('title')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-6">
                            <label class="form-label">Hero Sub-Title</label>
                            <input type="text" class="form-control" placeholder="Enter Hero Sub Title"
                                wire:model="sub_title">

                            @error('sub_title')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hero Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" wire:model="hero_image" accept="image/*">

                            {{-- Preview --}}
                            <div class="mt-2">
                                @if ($hero_image)
                                    <img src="{{ $hero_image->temporaryUrl() }}" class="img-thumbnail" width="120">
                                @elseif($old_hero_image)
                                    <img src="{{ $old_hero_image }}" class="img-thumbnail" width="120">
                                @else
                                    <img src="https://via.placeholder.com/120x80?text=No+Logo" class="img-thumbnail"
                                        width="120">
                                @endif
                            </div>

                            @error('hero_image')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>




                        <!-- Call Now Button -->
                        <div class="col-md-6">
                            <label class="form-label">Call Now Number</label>
                            <input type="text" class="form-control" placeholder="Enter Phone Number"
                                wire:model="phone_number">


                            @error('phone_number')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="col-12 d-flex align-items-center justify-content-end mt-3">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="save">
                                <span wire:loading wire:target="save">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Saving...
                                </span>
                                <span wire:loading.remove wire:target="save">
                                    Save
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
