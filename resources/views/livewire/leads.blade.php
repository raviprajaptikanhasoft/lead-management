<div>

    <div class="mb-3">
        <label for="statusFilter" class="form-label">Filter by Status:</label>
        <select id="statusFilter" class="form-select" wire:model="status">
            <option value="">All</option>
            <option value="new">New</option>
            <option value="won">Won</option>
            <option value="lost">Lost</option>
        </select>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Lead Name</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Owner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $lead)
                    <tr>
                        <td>{{ $lead->information->text1 }}</td>
                        <td>{{ $lead->information->text9 }}</td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($lead->status) }}</span>
                        </td>
                        <td>{{ $lead->user->name }}</td>
                        <td>
                            <button wire:click="updateStatus({{ $lead->id }}, 'won')"
                                class="btn btn-success btn-sm">Won</button>
                            <button wire:click="updateStatus({{ $lead->id }}, 'lost')"
                                class="btn btn-danger btn-sm">Lost</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        {{ $leads->links('livewire-pagination') }}
    </div>
</div>
