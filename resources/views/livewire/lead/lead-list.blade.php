<div>
    <h3 class="mb-3">Leads Management</h3>

    {{-- Filters --}}
    <div class="row mb-3">
        <div class="col-md-2">
            <select wire:model="status" class="form-control">
                <option value="">All Status</option>
                <option value="New">New</option>
                <option value="Won">Won</option>
                <option value="Lost">Lost</option>
            </select>
        </div>

        @if (auth()->user()->isAdmin())
            <div class="col-md-2">
                <select wire:model="user" class="form-control">
                    <option value="">All Users</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="col-md-2">
            <input type="date" wire:model="date" class="form-control">
        </div>

        <div class="col-md-1">
            <button wire:click="resetFilters" class="btn btn-secondary w-100">Reset</button>
        </div>
    </div>

    {{-- Table --}}
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-light">
            <tr>
                {{-- <th>#</th> --}}
                <th>Lead name</th>
                <th>Post URL</th>
                <th>Country</th>
                <th>Status</th>
                <th>Lead created by</th>
                <th>Created</th>
                <th width="220">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($leads as $lead)
                <tr>
                    {{-- <td>{{ $lead->id }}</td> --}}
                    <td>{{ $lead->information->text1 ?? '-' }}</td>
                    {{-- <td>{{ $lead->information->text3 ?? '-' }}</td> --}}
                    <td>
                        @if ($lead->information)
                            @if(strlen($lead->information->text3) > 40)
                                <a target="_blank" href="{{ $lead->information->text3 }}" class="text3-text" data-bs-toggle="tooltip" title="{{ $lead->information->text3 }}">
                                    {{ substr($lead->information->text3, 0, 40) . '...' }}
                                </a>
                            @else
                                <a target="_blank" href="{{ $lead->information->text3 }}">{{ $lead->information->text3 }}</a>
                            @endif
                        @endif
                    </td>
                    <td>{{ $lead->information->text9 ?? '-' }}</td>

                    {{-- Status Badge --}}
                    <td>
                        <span class="badge 
                            @if($lead->status === 'Won') bg-success
                            @elseif($lead->status === 'Lost') bg-danger
                            @else bg-secondary @endif">
                            {{ $lead->status }}
                        </span>
                    </td>

                    <td>{{ $lead->user->name ?? '-' }}</td>
                    <td>{{ $lead->created_at->format('d-m-Y') }}</td>

                    <td>
                        <div class="d-flex gap-2">

                            {{-- Status Dropdown --}}
                            <select class="form-select form-select-sm" wire:change="updateStatus({{ $lead->id }}, $event.target.value)">
                                <option value="">Change Status</option>
                                {{-- <option value="New" {{ $lead->status == 'New' ? 'selected' : '' }}>New</option> --}}
                                <option value="Won" {{ $lead->status == 'Won' ? 'selected' : '' }}>Won</option>
                                <option value="Lost" {{ $lead->status == 'Lost' ? 'selected' : '' }}>Lost</option>
                            </select>

                            <a wire:navigate href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No leads found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end">
        {{ $leads->links('livewire-pagination') }}
    </div>
</div>
