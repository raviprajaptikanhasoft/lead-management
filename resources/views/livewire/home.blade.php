<div>
    <div class="mb-3">
        <div class="row align-items-center">
            {{-- Total Leads --}}
            <div class="col-lg-2 col-md-3 mt-4">
                <div class="p-2 text-center alert alert-success rounded fw-bold mb-0">
                    Total Leads: {{ $total_records }}
                </div>
            </div>

            <div class="col-lg-10">
                <div class="row">
                    {{-- Search (Right-Aligned) --}}
                    <div class="col-lg-2 col-md-3 {{ Auth::user()->isadmin == 1 ? 'ms-auto' : 'ms-auto col-md-4' }}">
                        <label class="form-label small text-muted mb-1">&nbsp;</label>
                        <input wire:model="search" type="text" placeholder="Search..." class="form-control">
                    </div>

                    @if (Auth::user()->isadmin == 1)
                        {{-- Date From --}}
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small text-muted mb-0">From Date</label>
                            <input wire:model="date_from" type="date" class="form-control">
                        </div>

                        {{-- Date To --}}
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small text-muted mb-0">To Date</label>
                            <input wire:model="date_to" type="date" class="form-control">
                        </div>

                        {{-- User Filter --}}
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small text-muted mb-0">User</label>
                            <select wire:model="filter_user" class="form-control">
                                <option value="">All Users</option>
                                @foreach ($all_users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2">
                            <label class="form-label small text-muted mb-1">&nbsp;</label>
                            <button wire:click="resetFilters" class="btn btn-secondary w-100">
                                Reset Filters
                            </button>
                        </div>

                        {{-- Export CSV --}}
                        <div class="col-lg-2 col-md-2">
                            <label class="form-label small text-muted mb-1 d-block">&nbsp;</label>
                            <button wire:click="exportCsv" class="btn btn-success w-100" @if($users->count() == 0) disabled @endif>
                                <i class="bi bi-filetype-csv"></i> CSV
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="display table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th wire:click="sortBy('informations.text1')">Lead name</th>
                    <th wire:click="sortBy('informations.text2')">Designation</th>
                    <th wire:click="sortBy('informations.text6')">Linkedin Profile</th>
                    <th wire:click="sortBy('informations.text3')">Post URL</th>
                    <th wire:click="sortBy('informations.text4')">description</th>
                    {{-- <th wire:click="sortBy('informations.text5')">Company Name</th> --}}
                    <th wire:click="sortBy('informations.text7')">Email</th>
                    {{-- <th wire:click="sortBy('informations.text8')">Phone</th> --}}
                    <th wire:click="sortBy('users.name')">Created by</th>
                    <th wire:click="sortBy('informations.created_at')">Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody wire:poll.750ms>
                @if ($users->count() > 0)
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                @if(strlen($user->text1) > 20)
                                    <span class="text1-text tooltip-element cursor-pointer" data-tooltip-content="{{ $user->text1 }}">
                                        {{ substr($user->text1, 0, 20) . '...' }}
                                    </span>
                                @else
                                    {{ $user->text1 }}
                                @endif
                            </td>
                            <td>
                                @if(strlen($user->text2) > 20)
                                    <span class="text2-text tooltip-element cursor-pointer" data-tooltip-content="{{ $user->text2 }}">
                                        {{ substr($user->text2, 0, 20) . '...' }}
                                    </span>
                                @else
                                    {{ $user->text2 }}
                                @endif
                            </td>
                            <td>
                                @if(strlen($user->text6) > 20)
                                    <span class="text6-text tooltip-element cursor-pointer" data-tooltip-content="{{ $user->text6 }}">
                                        {{ substr($user->text6, 0, 20) . '...' }}
                                    </span>
                                @else
                                    {{ $user->text6 }}
                                @endif
                            </td>
                            <td>
                                @if(strlen($user->text3) > 20)
                                    <a target="_blank" href="{{ $user->text3 }}" class="text3-text tooltip-element cursor-pointer" data-tooltip-content="{{ $user->text3 }}">
                                        {{ substr($user->text3, 0, 20) . '...' }}
                                    </a>
                                @else
                                    <a target="_blank" href="{{ $user->text3 }}">{{ $user->text3 }}</a>
                                @endif
                            </td>
                            <td>
                                @if(strlen($user->text4) > 20)
                                    <span class="text4-text tooltip-element cursor-pointer" data-tooltip-content="{{ $user->text4 }}">
                                        {{ substr($user->text4, 0, 20) . '...'}}
                                    </span>
                                @else
                                    {{ $user->text4 }}
                                @endif
                            </td>
                            {{-- <td>
                                <span class="text5-text tooltip-element cursor-pointer" data-tooltip-content="{{ $user->text5 }}">
                                {{ strlen($user->text5) > 20 ? substr($user->text5, 0, 20) . '...' : $user->text5 }}
                                </span>
                            </td> --}}
                            <td>
                                @if(strlen($user->text7) > 20)
                                    <span class="text7-text tooltip-element cursor-pointer" data-tooltip-content="{{ $user->text7 }}">
                                        {{ substr($user->text7, 0, 20) . '...' }}
                                    </span>
                                @else
                                    {{ $user->text7 }}
                                @endif
                            </td>
                            {{-- <td>{{ substr($user->text8, 0, 50) }}</td> --}}
                            <td>{{ $user->user->name }}</td>
                            <td>{{ date('d-m-Y H:i:s',strtotime($user->created_at)) }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" wire:click="viewLead({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#leadModal">
                                    View
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

    <!-- Modal for Viewing Lead Details -->
    <!-- Simple Modal Design -->
    <div wire:ignore.self class="modal fade" id="leadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lead Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($selectedLead)
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="30%" class="text-muted">Lead Name:</th>
                                        <td class="text-wrap text-break">{{ $selectedLead->text1 }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Designation:</th>
                                        <td class="text-wrap text-break">{{ $selectedLead->text2 }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Company:</th>
                                        <td class="text-wrap text-break">{{ $selectedLead->text5 }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Email:</th>
                                        <td class="text-wrap text-break">
                                            {{ $selectedLead->text7 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Phone:</th>
                                        <td class="text-wrap text-break">
                                            {{ $selectedLead->text8 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">County:</th>
                                        <td class="text-wrap text-break">
                                            {{ $selectedLead->text9 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">LinkedIn:</th>
                                        <td class="text-wrap text-break">
                                            {{ $selectedLead->text6 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Post URL:</th>
                                        <td class="text-wrap text-break">
                                            @if($selectedLead->text3)
                                                <a href="{{ $selectedLead->text3 }}" target="_blank" class="text-decoration-none text-break">{{ $selectedLead->text3 }}</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Created By:</th>
                                        <td class="text-wrap text-break">
                                            {{ $selectedLead->user->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Date:</th>
                                        <td class="text-wrap text-break">
                                            {{ $selectedLead->created_at }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Description:</th>
                                        <td>
                                            <div class="border rounded p-3 bg-light text-wrap text-break" style="min-height: 80px; max-height: 150px; overflow-y: auto;">
                                                {{ $selectedLead->text4 }}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .pagination .page-link {
            font-size: 14px;
        }
        .table td .tooltip-text {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            vertical-align: middle;
        }

        /* Tooltip UI */
        .tooltip-inner {
            max-width: 300px !important;   /* bigger tooltip */
            background: #0d6efd !important;
            color: #fff !important;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            text-align: left;
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        /* Tooltip arrow color */
        .tooltip.bs-tooltip-top .tooltip-arrow::before { border-top-color: #0d6efd !important; }
        .tooltip.bs-tooltip-bottom .tooltip-arrow::before { border-bottom-color: #0d6efd !important; }
        .tooltip.bs-tooltip-start .tooltip-arrow::before { border-left-color: #0d6efd !important; }
        .tooltip.bs-tooltip-end .tooltip-arrow::before { border-right-color: #0d6efd !important; }

        /* Smooth fade */
        .tooltip {
            opacity: 1 !important;
            transition: opacity 0.25s ease-in-out;
        }

    </style>
@endpush

@push('scripts')
<script>
    // Simple and reliable tooltip initialization
    document.addEventListener('DOMContentLoaded', function() {
        initTooltips();
    });

    document.addEventListener('livewire:load', function() {
        initTooltips();
        
        // Better handling after Livewire updates
        Livewire.hook('message.processed', (message, component) => {
            // Check if this is a sort or filter operation
            if (message.updateQueue && message.updateQueue.length > 0) {
                console.log("message.updateQueue",message.updateQueue);
                const hasSortOrFilter = message.updateQueue.some(update =>
                 
                    update.type === 'callMethod' && 
                    (update.payload.method === 'sortBy' || 
                     update.payload.method === 'applyFilters' ||
                     update.payload.method === 'resetFilters' ||
                     update.payload.method === 'gotoPage')
                );
                
                if (hasSortOrFilter) {
                    // Wait a bit for DOM to settle
                    setTimeout(() => {
                        // Destroy all existing tooltips first
                        destroyAllTooltips();
                        // Reinitialize tooltips
                        initTooltips();
                    }, 50);
                } else {
                    // For other updates, just reinitialize
                    setTimeout(initTooltips, 50);
                }
            }
        });
    });

    function destroyAllTooltips() {
        // Destroy all existing tooltips
        const tooltipElements = document.querySelectorAll('.tooltip-element');
        tooltipElements.forEach(function(element) {
            const tooltipInstance = bootstrap.Tooltip.getInstance(element);
            if (tooltipInstance) {
                tooltipInstance.dispose();
                delete element._tooltipInstance;
            }
        });
    }

    function initTooltips() {
        // Get all tooltip elements
        const tooltipElements = document.querySelectorAll('.tooltip-element');
        
        tooltipElements.forEach(function(element) {
            // Skip if already has a tooltip instance
            if (element._tooltipInstance) {
                return;
            }
            
            try {
                // Get the tooltip content from data attribute
                const tooltipContent = element.getAttribute('data-tooltip-content');
                if (!tooltipContent) return;
                
                // Destroy any existing tooltip first
                const oldInstance = bootstrap.Tooltip.getInstance(element);
                if (oldInstance) {
                    oldInstance.dispose();
                }
                
                // Create new tooltip with minimal configuration
                const tooltip = new bootstrap.Tooltip(element, {
                    title: tooltipContent,
                    trigger: 'hover',
                    placement: 'top',
                    delay: 0,
                    animation: false,
                    boundary: 'viewport',
                    container: 'body',
                    fallbackPlacements: ['bottom', 'left', 'right']
                });
                
                // Store reference on element itself
                element._tooltipInstance = tooltip;
                
                // Add event listeners to ensure tooltip stays
                element.addEventListener('mouseenter', function(e) {
                    if (this._tooltipInstance) {
                        this._tooltipInstance.show();
                    }
                });
                
                element.addEventListener('mouseleave', function(e) {
                    if (this._tooltipInstance) {
                        // Don't hide immediately, check if mouse moved to tooltip
                        const relatedTarget = e.relatedTarget;
                        const tooltipElement = this._tooltipInstance.tip;
                        
                        if (tooltipElement && tooltipElement.contains(relatedTarget)) {
                            // Mouse moved to tooltip, don't hide yet
                            return;
                        }
                        
                        this._tooltipInstance.hide();
                    }
                });
                
                // Prevent tooltip from hiding when mouse moves to tooltip
                element.addEventListener('shown.bs.tooltip', function() {
                    const tooltipElement = this._tooltipInstance.tip;
                    if (tooltipElement) {
                        tooltipElement.addEventListener('mouseenter', () => {
                            // Keep tooltip visible when mouse is over it
                        });
                        
                        tooltipElement.addEventListener('mouseleave', (e) => {
                            if (this._tooltipInstance) {
                                this._tooltipInstance.hide();
                            }
                        });
                    }
                });
                
            } catch (error) {
                console.warn('Tooltip initialization error:', error);
            }
        });
    }

    document.addEventListener('livewire:load', function() {
        // Listen for modal open event
        Livewire.on('openLeadModal', () => {
            const modal = new bootstrap.Modal(document.getElementById('leadModal'));
            modal.show();
        });
        
        // Reset selectedLead when modal is closed
        document.getElementById('leadModal').addEventListener('hidden.bs.modal', function () {
            // You can optionally reset the selectedLead here
            // Livewire.emit('resetSelectedLead');
        });
    });
</script>
@endpush