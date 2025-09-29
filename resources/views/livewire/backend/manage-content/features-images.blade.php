<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">Features Images</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <form class="row g-3" wire:submit.prevent="save">


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Resort Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" wire:model="resort_image" accept="image/*">


                            <div class="mt-2">
                                @if ($resort_image)
                                    <img src="{{ $resort_image->temporaryUrl() }}" class="img-thumbnail" width="120">
                                @elseif($old_resort_image)
                                    <img src="{{ $old_resort_image }}" class="img-thumbnail" width="120">
                                @else
                                    <img src="https://via.placeholder.com/120x80?text=No+Logo" class="img-thumbnail"
                                        width="120">
                                @endif
                            </div>

                            @error('resort_image')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>





                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" wire:model="event_image" accept="image/*">


                            <div class="mt-2">
                                @if ($event_image)
                                    <img src="{{ $event_image->temporaryUrl() }}" class="img-thumbnail" width="120">
                                @elseif($old_event_image)
                                    <img src="{{ $old_event_image }}" class="img-thumbnail" width="120">
                                @else
                                    <img src="https://via.placeholder.com/120x80?text=No+Logo" class="img-thumbnail"
                                        width="120">
                                @endif
                            </div>

                            @error('event_image')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>




                        <!-- Submit Button -->
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


<script>
    function togglePassword(id, el) {
        let input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
            el.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            input.type = "password";
            el.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
