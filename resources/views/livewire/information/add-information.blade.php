<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addLeadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form wire:submit.prevent="saveLead" onkeydown="return event.key !== 'Enter';">
                    <div class="modal-body">
                        <div class="row g-2">

                            <div class="col-md-6">
                                <label class="form-label">Lead Name</label>
                                <input type="text" class="form-control" wire:model="text1" placeholder="Lead Name">
                                @error('text1') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" wire:model="text2" placeholder="Designation">
                                @error('text2') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Post URL</label>
                                <input type="text" class="form-control" wire:model="text3" placeholder="Post URL">
                                @error('text3') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" wire:model="text4" placeholder="Description">
                                @error('text4') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" wire:model="text5" placeholder="Company Name">
                                @error('text5') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">LinkedIn Profile</label>
                                <input type="text" class="form-control" wire:model="text6" placeholder="LinkedIn Profile">
                                @error('text6') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" wire:model="text7" placeholder="Email">
                                @error('text7') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" wire:model="text8" placeholder="Phone">
                                @error('text8') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                {{-- <input type="text" class="form-control" wire:model="text9" placeholder="Country"> --}}
                                <select class="form-select" wire:model="text9">
                                    <option value="">Select Country</option>

                                    @foreach($countries as $country)
                                        <option value="{{ $country['name'] }}">
                                            {{ $country['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('text9') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-secondary" wire:click="resetForm">Reset</button>
                        <button type="submit" class="btn btn-success">Save Lead</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        (function () {
            // helper: emit to Livewire (v2) or dispatch (v3)
            function sendResetToLivewire() {
                if (window.Livewire && typeof window.Livewire.emit === 'function') {
                    window.Livewire.emit('resetLeadForm');        // v2
                } else if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                    window.Livewire.dispatch('resetLeadForm');    // v3
                } else if (window.dispatchEvent) {
                    // fallback custom event (component could listen to it)
                    window.dispatchEvent(new CustomEvent('resetLeadForm'));
                }
            }

            // show modal when Livewire triggers open
            window.addEventListener('open-add-lead-modal', () => {
                const modalEl = document.getElementById('addLeadModal');
                if (!modalEl) return;
                // ensure form cleared BEFORE showing (component does reset in openModal)
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });

            // hide modal when Livewire tells to close
            window.addEventListener('close-add-lead-modal', () => {
                const modalEl = document.getElementById('addLeadModal');
                if (!modalEl) return;
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });

            // when user closes modal manually (X, Cancel, backdrop), notify Livewire to reset
            document.addEventListener('DOMContentLoaded', function () {
                const modalEl = document.getElementById('addLeadModal');
                if (!modalEl) return;
                modalEl.addEventListener('hidden.bs.modal', function () {
                    // notify Livewire to reset component state
                    sendResetToLivewire();
                });
            });

            // Also attach the listener after Livewire load (in case component is injected later)
            document.addEventListener('livewire:load', function () {
                const modalEl = document.getElementById('addLeadModal');
                if (!modalEl) return;
                // avoid duplicate handlers
                modalEl.removeEventListener('hidden.bs.modal', () => {});
                modalEl.addEventListener('hidden.bs.modal', function () {
                    sendResetToLivewire();
                });
            });

        })();
    </script>
</div>
