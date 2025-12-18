@extends('layouts.app')

@section('content')
@livewireStyles

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Leads Management</h4>

                {{-- This button will open modal created inside Livewire component --}}
                <button class="btn btn-primary" data-bs-toggle="modal" wire:click="$emit('openAddLeadModal')" data-bs-target="#addLeadModal">
                    Add New Lead
                </button>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            {{-- Load Livewire component (Lead add) --}}
            @livewire('add-lead')
            {{-- Load Livewire component (this contains table + modal) --}}
            @livewire('home')

        </div>
    </div>
</div>

@livewireScripts
@endsection
