<?php

namespace App\Http\Livewire;

use App\Models\Lead;
use App\Models\LeadNote;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Leads extends Component
{
    use WithPagination;

    public $status;
    public $perPage = 25;
    public $note = '';
    public $selectedLead;


    public function render()
    {
        $query = Lead::with(['information', 'user', 'notes']);

        if (Auth::user()->isadmin == 0) {
            $query->where('user_id', Auth::id());
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return view('livewire.leads', [
            'leads' => $query->latest()->paginate($this->perPage),
        ]);
    }

    public function updateStatus($id, $status)
    {
        Lead::findOrFail($id)->update(['status' => $status]);
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Status updated successfully!'
        ]);
    }

    public function addNote()
    {
        LeadNote::create([
            'lead_id' => $this->selectedLead,
            'user_id' => Auth::id(),
            'note' => $this->note,
        ]);

        $this->note = '';
    }
}
