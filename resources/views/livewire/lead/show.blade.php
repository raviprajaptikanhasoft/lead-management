<div class="container-fluid">
    <div class="card border-0 shadow-sm">

        {{-- HEADER --}}
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i>
                    Lead #{{ $lead->id }}
                </h5>
                <small class="text-muted">
                    Created {{ $lead->created_at->format('d M Y') }}
                </small>
            </div>

            <div class="d-flex align-items-center gap-3">
                {{-- Toggle Details Button --}}
                <button wire:click="toggleDetails" class="btn btn-outline-primary btn-sm" type="button">
                    <i class="bi bi-{{ $showDetails ? 'eye-slash' : 'eye' }} me-1"></i>
                    {{ $showDetails ? 'Hide Details' : 'Show Details' }}
                </button>

                {{-- Status --}}
                <span
                    class="badge rounded-pill px-3 py-2
                    @if ($lead->status === 'Won') bg-success
                    @elseif($lead->status === 'Lost') bg-danger
                    @elseif($lead->status === 'In Progress') bg-primary
                    @else bg-secondary @endif">
                    {{ $lead->status ?? 'New' }}
                </span>
            </div>
        </div>

        {{-- DETAILS SECTION (Collapsible) --}}
        @if ($showDetails)

            <div class="card-body border-bottom bg-light-subtle" wire:transition.opacity.duration.300ms>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0 text-primary">
                        <i class="bi bi-info-circle me-2"></i>
                        Lead Information
                    </h6>
                    <button wire:click="toggleDetails" class="btn btn-sm btn-outline-secondary" type="button">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="row g-4">
                    {{-- Left Column - Contact Info --}}
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="fw-semibold mb-0">
                                    <i class="bi bi-person-badge me-2"></i>
                                    Contact Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Name</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-person text-primary"></i>
                                        </div>
                                        <span class="fw-medium">{{ $lead->information->text1 ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Designation</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-briefcase text-info"></i>
                                        </div>
                                        <span>{{ $lead->information->text2 ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Company</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-building text-success"></i>
                                        </div>
                                        <span>{{ $lead->information->text5 ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Email</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-envelope text-warning"></i>
                                        </div>
                                        @if ($lead->information->text7)
                                            <a href="mailto:{{ $lead->information->text7 }}"
                                                class="text-decoration-none">
                                                {{ $lead->information->text7 }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Phone</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-telephone text-danger"></i>
                                        </div>
                                        <span>{{ $lead->information->text8 ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="small text-muted d-block mb-1">Country</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-globe text-secondary"></i>
                                        </div>
                                        <span>{{ $lead->information->text9 ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column - Additional Info --}}
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="fw-semibold mb-0">
                                    <i class="bi bi-link-45deg me-2"></i>
                                    Additional Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">LinkedIn Profile</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-linkedin text-primary"></i>
                                        </div>
                                        <span>{{ $lead->information->text6 ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Post URL</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-link text-info"></i>
                                        </div>
                                        @if ($lead->information->text3)
                                            <a href="{{ $lead->information->text3 }}" target="_blank"
                                                class="text-decoration-none text-truncate d-block"
                                                style="max-width: 200px;">
                                                {{ $lead->information->text3 }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Created By</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-person-plus text-success"></i>
                                        </div>
                                        <span>{{ $lead->user->name ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Date Created</label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-2">
                                            <i class="bi bi-calendar text-warning"></i>
                                        </div>
                                        <span>{{ $lead->created_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Full Width - Description --}}
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="fw-semibold mb-0">
                                    <i class="bi bi-card-text me-2"></i>
                                    Description
                                </h6>
                            </div>
                            <div class="card-body">
                                @if ($lead->information->text4)
                                    <div class="p-3 bg-white border rounded" style="min-height: 80px;">
                                        <p class="mb-0">{{ $lead->information->text4 }}</p>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-card-text text-muted fs-4 d-block mb-2"></i>
                                        <span class="text-muted">No description provided</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="card-body">

            {{-- ADD NOTE --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">
                    <i class="bi bi-pencil-square me-1"></i>
                    Add Note
                </label>

                <textarea wire:model.defer="note" class="form-control form-control-lg @error('note') is-invalid @enderror"
                    rows="2" placeholder="Type your note and press Add..."></textarea>

                @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Notes will be visible to all team members
                    </small>
                    <button wire:click="addNote" class="btn btn-primary px-4">
                        <i class="bi bi-plus-circle me-1"></i> Add Note
                    </button>
                </div>
            </div>

            <hr class="my-4">

            {{-- NOTES TIMELINE --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-1"></i>
                    Activity Timeline
                </h6>
                <small class="text-muted">
                    {{ $totalNotesCount }} {{ Str::plural('note', $totalNotesCount) }}
                    @if ($notes->count() < $totalNotesCount)
                        (Showing {{ $notes->count() }} of {{ $totalNotesCount }})
                    @endif
                </small>
            </div>

            <div class="timeline">
                @forelse ($notes as $n)
                    <div class="timeline-item">
                        <div class="timeline-icon bg-primary">
                            <i class="bi bi-chat-dots"></i>
                        </div>

                        <div class="timeline-content card border">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $n->user->name }}</strong>
                                    </div>
                                    <small class="text-muted">
                                        {{ $n->created_at->format('d M Y, h:i A') }}
                                    </small>
                                </div>

                                <p class="mb-0 mt-2">
                                    {{ $n->note }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat-square-dots fs-1 d-block mb-3"></i>
                        <p class="mb-0">No notes added yet</p>
                        <small>Start by adding your first note above</small>
                    </div>
                @endforelse
            </div>

            {{-- Show more button if there are more notes --}}
            @if ($notes->hasMorePages())
                <div class="text-center mt-4">
                    <button wire:click="loadMore" class="btn btn-outline-secondary btn-sm"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="loadMore">
                            <i class="bi bi-chevron-down me-1"></i>
                            Load More Notes ({{ $notes->count() }}/{{ $totalNotesCount }})
                        </span>
                        <span wire:loading wire:target="loadMore">
                            <i class="bi bi-arrow-clockwise spin me-1"></i>
                            Loading...
                        </span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <style>
        .timeline {
            position: relative;
            margin-left: 20px;
            padding-left: 20px;
            border-left: 2px solid #dee2e6;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-icon {
            position: absolute;
            left: -30px;
            top: 15px;
            width: 24px;
            height: 24px;
            background-color: #0d6efd;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .timeline-content {
            padding-left: 10px;
        }

        .timeline-item:hover .timeline-icon {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Loading spinner animation */
        .bi-arrow-clockwise.spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
