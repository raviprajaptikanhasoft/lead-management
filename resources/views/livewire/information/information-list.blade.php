<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Infomation Management</h4>

                {{-- This button will open modal created inside Livewire component --}}
                <button class="btn btn-primary" wire:click="$emit('openAddLeadModal')">
                    <i class="bi bi-plus-circle me-1"></i> Add New
                </button>
            </div>

            {{-- Load Livewire component (Lead add) --}}
            <livewire:information.add-information />
            {{-- Load Livewire component (this contains table + modal) --}}
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
                                <div
                                    class="col-lg-2 col-md-3 {{ Auth::user()->isadmin == 1 ? 'ms-auto' : 'ms-auto col-md-4' }}">
                                    <label class="form-label small text-muted mb-1">&nbsp;</label>
                                    <input wire:model="search" type="text" placeholder="Search..."
                                        class="form-control">
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

                                            <optgroup label="Active Users">
                                                @foreach ($all_users->where('is_active', 1) as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </optgroup>

                                            @if($all_users->where('is_active', 0)->count() > 0)
                                                <optgroup label="Inactive Users">
                                                    @foreach ($all_users->where('is_active', 0) as $iuser)
                                                        <option value="{{ $iuser->id }}">{{ $iuser->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-2">
                                        <label class="form-label small text-muted mb-1">&nbsp;</label>
                                        <button wire:click="resetFilters" class="btn btn-secondary w-100"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                                    </div>

                                    {{-- Export CSV --}}
                                    <div class="col-lg-2 col-md-2">
                                        <label class="form-label small text-muted mb-1 d-block">&nbsp;</label>
                                        <button wire:click="exportCsv" class="btn btn-success w-100"
                                            @if ($informations->count() == 0) disabled @endif>
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
                                <th wire:click="sortBy('informations.text9')">Country</th>
                                <th wire:click="sortBy('users.name')">Created by</th>
                                <th wire:click="sortBy('informations.created_at')">Date</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($informations->count() > 0)
                                @foreach ($informations as $information)
                                    <tr>
                                        <td>
                                            @if (strlen($information->text1) > 20)
                                                <span class="text1-text tooltip-element cursor-pointer"
                                                    data-tooltip-content="{{ $information->text1 }}">
                                                    {{ substr($information->text1, 0, 20) . '...' }}
                                                </span>
                                            @else
                                                {{ $information->text1 }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strlen($information->text2) > 20)
                                                <span class="text2-text tooltip-element cursor-pointer"
                                                    data-tooltip-content="{{ $information->text2 }}">
                                                    {{ substr($information->text2, 0, 20) . '...' }}
                                                </span>
                                            @else
                                                {{ $information->text2 }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strlen($information->text6) > 20)
                                                <span class="text6-text tooltip-element cursor-pointer"
                                                    data-tooltip-content="{{ $information->text6 }}">
                                                    {{ substr($information->text6, 0, 20) . '...' }}
                                                </span>
                                            @else
                                                {{ $information->text6 }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strlen($information->text3) > 20)
                                                <a target="_blank" href="{{ $information->text3 }}"
                                                    class="text3-text tooltip-element cursor-pointer"
                                                    data-tooltip-content="{{ $information->text3 }}">
                                                    {{ substr($information->text3, 0, 20) . '...' }}
                                                </a>
                                            @else
                                                <a target="_blank"
                                                    href="{{ $information->text3 }}">{{ $information->text3 }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (strlen($information->text4) > 20)
                                                <span class="text4-text tooltip-element cursor-pointer"
                                                    data-tooltip-content="{{ $information->text4 }}">
                                                    {{ substr($information->text4, 0, 20) . '...' }}
                                                </span>
                                            @else
                                                {{ $information->text4 }}
                                            @endif
                                        </td>
                                        {{-- <td>
                                <span class="text5-text tooltip-element cursor-pointer" data-tooltip-content="{{ $information->text5 }}">
                                {{ strlen($information->text5) > 20 ? substr($information->text5, 0, 20) . '...' : $information->text5 }}
                                </span>
                            </td> --}}
                                        <td>
                                            @if (strlen($information->text7) > 20)
                                                <span class="text7-text tooltip-element cursor-pointer"
                                                    data-tooltip-content="{{ $information->text7 }}">
                                                    {{ substr($information->text7, 0, 20) . '...' }}
                                                </span>
                                            @else
                                                {{ $information->text7 }}
                                            @endif
                                        </td>
                                        {{-- <td>{{ substr($information->text8, 0, 50) }}</td> --}}
                                        <td>{{ substr($information->text9, 0, 20) }}</td>
                                        <td>{{ $information->user->name ?? '-' }}</td>
                                        <td>{{ $information->created_at->format('d-m-Y H:i:s') }}</td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-center gap-1 flex-nowrap">
                                                <button class="btn btn-sm btn-primary" wire:click="viewLead({{ $information->id }})" title="View Lead Details" data-bs-toggle="modal" data-bs-target="#leadModal"><i class="bi bi-eye-fill"></i></button>
                                                <button class="btn btn-sm btn-success" wire:click="convertToLead({{ $information->id }})" title="Convert to Lead"><i class="bi bi-person-plus-fill"></i></button>
                                            </div>
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
                    {{ $informations->links('livewire-pagination') }}
                </div>

                <!-- Modal for Viewing Lead Details -->
                <!-- Simple Modal Design -->
                <div wire:ignore.self class="modal fade" id="leadModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow-sm">
                            <!-- Simple Header -->
                            <div class="modal-header border-bottom bg-light">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle bg-primary-subtle text-primary">
                                        <i class="bi bi-person fs-5"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title mb-0 fw-bold">Information Details</h5>
                                        {{-- <small class="text-muted">ID: #{{ $selectedLead->id ?? '' }}</small> --}}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body p-0">
                                @if ($selectedLead)
                                    <!-- Lead Info in Clean Layout -->
                                    <div class="p-4 pt-0">
                                        <!-- Information Table - Clean & Simple -->
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-muted" style="width: 30%"><i class="bi bi-person-circle me-2"></i>Lead Name:
                                                        </td>
                                                        <td>{{ $selectedLead->text1 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted" style="width: 30%"><i class="bi bi-briefcase me-2"></i>Designation:</td>
                                                        <td>{{ $selectedLead->text2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted" style="width: 30%"><i class="bi bi-building me-2"></i>Company Name:</td>
                                                        <td>{{ $selectedLead->text5 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted" style="width: 30%"><i class="bi bi-envelope me-2"></i>Email:</td>
                                                        <td>{{ $selectedLead->text7 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted"><i class="bi bi-telephone me-2"></i>Phone:</td>
                                                        <td>{{ $selectedLead->text8 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted"><i class="bi bi-geo-alt me-2"></i>Country:</td>
                                                        <td>{{ $selectedLead->text9 }}</td>
                                                    </tr>
                                                    @if ($selectedLead->text6)
                                                        <tr>
                                                            <td class="text-muted"><i class="bi bi-linkedin me-2"></i>LinkedIn:</td>
                                                            <td>{{ $selectedLead->text6 }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($selectedLead->text3)
                                                        <tr>
                                                            <td class="text-muted"><i class="bi bi-link-45deg me-2"></i>Post URL:</td>
                                                            <td>
                                                                <a href="{{ $selectedLead->text3 }}" target="_blank"
                                                                    class="text-decoration-none text-truncate" title="{{ $selectedLead->text3 }}">
                                                                    Visit Post
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="text-muted"><i class="bi bi-person-plus me-2"></i>Created By:</td>
                                                        <td>{{ $selectedLead->user->name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted"><i class="bi bi-calendar me-2"></i>Date Created:</td>
                                                        <td>{{ $selectedLead->created_at->format('d M Y, H:i') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Description Box -->
                                        <div class="pt-3 border-top">
                                            <h6 class="text-muted mb-2">
                                                <i class="bi bi-card-text me-2"></i>Description
                                            </h6>
                                            <div class="bg-light rounded p-2">
                                                <p class="mb-0 text-wrap text-break">
                                                    {{ $selectedLead->text4 ?: 'No description provided' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="text-center py-5">
                                        <i class="bi bi-person text-muted fs-1 mb-3"></i>
                                        <p class="text-muted mb-0">Select a lead to view details</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
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
            max-width: 300px !important;
            /* bigger tooltip */
            background: #0d6efd !important;
            color: #fff !important;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            text-align: left;
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        /* Tooltip arrow color */
        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #0d6efd !important;
        }

        .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
            border-bottom-color: #0d6efd !important;
        }

        .tooltip.bs-tooltip-start .tooltip-arrow::before {
            border-left-color: #0d6efd !important;
        }

        .tooltip.bs-tooltip-end .tooltip-arrow::before {
            border-right-color: #0d6efd !important;
        }

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
                    console.log("message.updateQueue", message.updateQueue);
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
            document.getElementById('leadModal').addEventListener('hidden.bs.modal', function() {
                // You can optionally reset the selectedLead here
                // Livewire.emit('resetSelectedLead');
            });
        });
    </script>
@endpush
