<div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,.5)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle"></i> Confirm Delete
                </h5>
                <button type="button" class="btn-close" wire:click="$set('confirmingDelete', false)"></button>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
                <small class="text-muted">This action cannot be undone.</small>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" wire:click="$set('confirmingDelete', false)">
                    Cancel
                </button>

                <button class="btn btn-danger" wire:click="deleteUser">
                    Yes, Delete
                </button>
            </div>

        </div>
    </div>
</div>
