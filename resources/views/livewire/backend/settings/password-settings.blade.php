<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">Password Settings</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form class="row g-3" wire:submit.prevent="save">

                        <!-- Old Password -->
                        <div class="col-md-4 position-relative">
                            <label class="form-label">Old Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" wire:model.defer="old_password"
                                id="old_password">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer;"
                                onclick="togglePassword('old_password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="col-md-4 position-relative">
                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" wire:model.defer="new_password"
                                id="new_password">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer;"
                                onclick="togglePassword('new_password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="col-md-4 position-relative">
                            <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" wire:model.defer="confirm_new_password"
                                id="confirm_new_password">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer;"
                                onclick="togglePassword('confirm_new_password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                            @error('confirm_new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            input.type = "password";
            icon.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
