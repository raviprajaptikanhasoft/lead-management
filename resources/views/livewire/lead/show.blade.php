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

            {{-- Status --}}
            <span
                class="badge rounded-pill px-3 py-2
                @if ($lead->status === 'Won') bg-success
                @elseif($lead->status === 'Lost') bg-danger
                @else bg-secondary @endif">
                {{ $lead->status ?? 'New' }}
            </span>
        </div>

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

                <div class="d-flex justify-content-end mt-3">
                    <button wire:click="addNote" class="btn btn-primary px-4">
                        <i class="bi bi-plus-circle me-1"></i> Add Note
                    </button>
                </div>
            </div>

            <hr class="my-4">

            {{-- NOTES TIMELINE --}}
            <h6 class="fw-bold mb-4">
                <i class="bi bi-clock-history me-1"></i>
                Activity Timeline
            </h6>

            <div class="timeline">

                @forelse ($notes as $n)
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>

                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $n->user->name }}</strong>
                                <small class="text-muted">
                                    {{ $n->created_at->format('d M Y, h:i A') }}
                                </small>
                            </div>

                            <p class="mb-0 text-muted">
                                {{ $n->note }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-chat-square-dots fs-1 d-block mb-2"></i>
                        No notes added yet
                    </div>
                @endforelse

            </div>
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
            top: 0;
            width: 24px;
            height: 24px;
            background-color: #0d6efd;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timeline-content {
            padding-left: 10px;
        }
    </style>
@endpush
