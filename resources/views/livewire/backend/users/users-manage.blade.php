<div>
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">Users Management</h5>
        </div>
        <div class="col-auto">
            <a data-bs-toggle="modal" data-bs-target="#adduser" wire:click="resetInputFields"
                class="btn btn-icon btn-3 btn-white text-primary mb-0">
                <i class="fa fa-plus me-2"></i> Add New User
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <input type="text" class="form-control" placeholder="Search by name , email or phone no."
                                wire:model="search" />

                            <button type="button" wire:click="searchUsers" class="btn btn-primary mt-2">
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
                                        First Name</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7 ps-2">
                                        Last Name</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">
                                        Contact</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">Is Active</th>
                                    <th class="text-uppercase text-secondary text-xs opacity-7">Email Verified</th>
                                    <th class="text-uppercase text-secondary text-xs  opacity-7">
                                        Created</th>
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
                                            <p class="text-sm font-weight-bold mb-0">{{ $row->f_name }}</p>
                                        </td>

                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $row->l_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm px-3 mb-0">{{ $row->phone_no }}</p>
                                            <p class="text-sm px-3 mb-0">{{ $row->email }}</p>
                                        </td>

                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {!! activeBadge($row->is_active, $row->id) !!}
                                            </p>
                                        </td>

                                        <td>
                                            @if ($row->email_verified_at)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning">Not Verified</span>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $row->created_at->format('d M Y') }}</p>
                                        </td>
                                        <td>

                                            <a data-bs-toggle="modal" data-bs-target="#edituser"
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
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No users found</td>
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


    <div wire:ignore.self class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="adduser"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="adduser">Add User</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="row g-2 align-items-center">

                            <!-- First Name -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter First Name"
                                    wire:model="first_name">
                                @error('first_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter Last Name"
                                    wire:model="last_name">
                                @error('last_name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" required class="form-control" placeholder="Enter Email Address"
                                    wire:model="email">
                                @error('email')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" required class="form-control" placeholder="Enter Phone Number"
                                    wire:model="phone_no">
                                @error('phone_no')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" required class="form-control" placeholder="Enter Password"
                                        wire:model="password" id="password">
                                    <span class="input-group-text" onclick="togglePassword('password')">
                                        <i id="password-icon" class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-12 mb-1">
                                <label class="form-label">Confirm Password
                                    <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" required class="form-control"
                                        placeholder="Enter Confirm Password" wire:model="password_confirmation"
                                        id="password_confirmation">
                                    <span class="input-group-text" onclick="togglePassword('password_confirmation')">
                                        <i id="confirm-password-icon" class="fas fa-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div class="col-md-12 mb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" checked
                                        wire:model="is_active">
                                    <label class="form-check-label" for="is_active">Is Active ?</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                        <div class="">
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

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="edituser" tabindex="-1" role="dialog"
        aria-labelledby="edituser" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600" id="edituser">Edit User</h6>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times" style="color:black;"></i>
                    </button>
                </div>

                <form wire:submit.prevent="update">
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
    </div>



</div>

<script>
    Livewire.on('confirmDelete', userId => {
        if (confirm("Are you sure you want to delete this user? This action cannot be undone.")) {
            Livewire.dispatch('deleteUser', {
                id: userId
            });
        }
    });

    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);

        let passwordIconId;

        if (fieldId === 'edit_password') {
            passwordIconId = 'edit-password-icon';
        } else if (fieldId === 'edit_password_confirmation') {
            passwordIconId = 'edit-confirm-password-icon';
        } else if (fieldId === 'new_password') {
            passwordIconId = 'new-password-icon';
        } else if (fieldId === 'new_password_confirmation') {
            passwordIconId = 'confirm-new-password-icon';
        } else if (fieldId === 'old_password') {
            passwordIconId = 'old-password-icon';
        }

        const passwordIcon = document.getElementById(passwordIconId);

        // Toggle password visibility
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.classList.add('fa-eye');
            passwordIcon.classList.remove('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            passwordIcon.classList.add('fa-eye-slash');
            passwordIcon.classList.remove('fa-eye');
        }
    }
</script>
