<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Users Management</h4>
                <div class="d-flex align-items-center gap-2">
                    {{-- Search (Right-Aligned) --}}
                    <div class="d-flex align-items-center"
                        class="{{ Auth::user()->isadmin == 1 ? 'ms-auto' : 'ms-auto col-md-4' }}">
                        <label class="form-label small text-muted mb-1">&nbsp;</label>
                        <input wire:model="search" type="text" placeholder="Search..." class="form-control">
                    </div>
                    {{-- This button will open modal created inside Livewire component --}}
                    <button class="btn btn-primary" wire:click="openCreateModal">
                        <i class="bi bi-plus-circle me-1"></i> Add User
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="example" class="display table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->count() > 0)
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                wire:click="toggleStatus({{ $user->id }})"
                                                {{ $user->is_active ? 'checked' : '' }}>
                                        </div>
                                        <small
                                            class="fw-semibold {{ $user->is_active ? 'text-success' : 'text-danger' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </small>
                                    </td>
                                    <td class="text-center gap-2 d-flex justify-content-center">
                                        <button class="btn btn-sm btn-outline-primary"
                                            wire:click="edit({{ $user->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="confirmDelete({{ $user->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center text-muted py-3">
                                    No records found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $users->links('livewire-pagination') }}
            </div>

        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $isEdit ? 'Edit User' : 'Add User' }}
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Name</label>
                        <input wire:model="name" class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label>Email</label>
                        <input wire:model="email" class="form-control">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label>Password</label>
                        <input wire:model="password" type="password" class="form-control">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" wire:model="is_active">
                        <label class="form-check-label">Active</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model="isadmin">
                        <label class="form-check-label">Is Admin</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button wire:click="save" class="btn btn-primary">
                        {{ $isEdit ? 'Update' : 'Save' }}
                    </button>
                </div>

            </div>
        </div>
    </div>

    @if ($confirmingDelete)
        @include('livewire.components.delete-popup')
    @endif

</div>

@push('scripts')
    <script>
        window.addEventListener('show-user-modal', () => {
            new bootstrap.Modal(document.getElementById('userModal')).show();
        });

        window.addEventListener('hide-user-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
        });
    </script>
@endpush
