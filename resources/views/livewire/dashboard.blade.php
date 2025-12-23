<div class="dashboard-container">

    {{-- PAGE HEADER --}}
    <div class="dashboard-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="dashboard-title mb-1">Dashboard Overview</h1>
            </div>
            <div class="mt-2 mt-md-0">
                <div class="date-display d-flex align-items-center">
                    <i class="bi bi-calendar3 me-2"></i>
                    <span class="fw-medium">{{ now()->format('l, d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-xl-2 col-lg-3 col-md-4">
                    <label class="form-label fw-semibold small mb-1">Date Range</label>
                    <select wire:model="range" class="form-select form-select-sm">
                        <option value="today">Today</option>
                        <option value="7days">Last 7 Days</option>
                        <option value="30days">Last 30 Days</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>

                @if ($range === 'custom')
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <label class="form-label fw-semibold small mb-1">From Date</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" wire:model="fromDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4">
                        <label class="form-label fw-semibold small mb-1">To Date</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" wire:model="toDate" class="form-control">
                        </div>
                    </div>
                @endif

                @if (auth()->user()->isAdmin())
                    <div class="col-xl-3 col-lg-4" wire:ignore.self>
                        <label class="form-label fw-semibold small mb-1">Filter Users</label>
                        <select id="userSelect" class="form-select form-select-sm" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- <div class="col-xl-2 col-lg-3 col-md-4">
                    <button class="btn btn-primary btn-sm w-100" wire:click="$refresh">
                        <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                    </button>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- KPI DASHBOARD --}}
    <div class="row g-3 mb-4">
        {{-- Approaches Card --}}
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon-wrapper bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-megaphone"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Approaches</h6>
                            <h3 class="fw-bold mb-0">{{ $approaches }}</h3>
                            <small class="text-muted">
                                <i class="bi bi-eye me-1"></i>Initial Contacts
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Leads Card --}}
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon-wrapper bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Leads</h6>
                            <h3 class="fw-bold mb-0">{{ $leads }}</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up-right me-1"></i>
                                From {{ $approaches }} approaches
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- New Leads Card --}}
        {{-- <div class="col-xl-3 col-md-6">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="kpi-icon-wrapper bg-info bg-opacity-10 text-info me-3">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">New Leads</h6>
                            <h3 class="fw-bold mb-0">{{ $leadNew }}</h3>
                            <small class="text-info">
                                <i class="bi bi-clock me-1"></i>In progress
                            </small>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Of Total Leads</small>
                            <small class="fw-semibold">
                                @php
                                    $newLeadsPercentage = $leads > 0 ? round(($leadNew / $leads) * 100, 1) : 0;
                                @endphp
                                {{ $newLeadsPercentage }}%
                            </small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" 
                                 style="width: {{ $newLeadsPercentage }}%"
                                 role="progressbar"
                                 aria-valuenow="{{ $newLeadsPercentage }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- Won Leads Card --}}
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted mb-1">Won Leads</h6>
                            <h2 class="fw-bold text-success mb-0">{{ $leadWon }}</h2>
                        </div>
                        <div class="kpi-icon-circle bg-success bg-opacity-10 text-success">
                            <i class="bi bi-trophy"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Win Rate</small>
                            <small class="fw-semibold text-success">
                                @php
                                    $winRate = $leads > 0 ? round(($leadWon / $leads) * 100, 1) : 0;
                                @endphp
                                {{ $winRate }}%
                            </small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: {{ $winRate }}%" role="progressbar"
                                aria-valuenow="{{ $winRate }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lost Leads Card --}}
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted mb-1">Lost Leads</h6>
                            <h2 class="fw-bold text-danger mb-0">{{ $leadLost }}</h2>
                        </div>
                        <div class="kpi-icon-circle bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Loss Rate</small>
                            <small class="fw-semibold text-danger">
                                @php
                                    $lossRate = $leads > 0 ? round(($leadLost / $leads) * 100, 1) : 0;
                                @endphp
                                {{ $lossRate }}%
                            </small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" style="width: {{ $lossRate }}%" role="progressbar"
                                aria-valuenow="{{ $lossRate }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .dashboard-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .dashboard-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.75rem;
    }

    .filter-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: white;
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .kpi-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        background: white;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08) !important;
    }

    .kpi-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .kpi-icon-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .date-display {
        background: #f1f5f9;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
        background-color: #e2e8f0;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 0.6s ease;
    }
</style>


@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {

            let component = @this;

            function initSelect2() {
                if (!$('#userSelect').length) return;

                // Destroy previous instance safely
                if ($('#userSelect').hasClass("select2-hidden-accessible")) {
                    $('#userSelect').off('change');
                    $('#userSelect').select2('destroy');
                }

                $('#userSelect').select2({
                    placeholder: "Select Users",
                    allowClear: true,
                    width: '100%'
                });

                // 👉 SET selected values FROM Livewire
                let selected = component.get('selectedUsers') || [];
                $('#userSelect').val(selected).trigger('change.select2');

                // 👉 SEND selected values TO Livewire
                $('#userSelect').on('change', function() {
                    let values = $(this).val() || [];
                    component.set('selectedUsers', values);
                });
            }

            initSelect2();

            // 🔁 Re-init after Livewire updates
            Livewire.hook('message.processed', function() {
                initSelect2();
            });
        });
    </script>
@endpush
