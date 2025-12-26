<?php

namespace App\Http\Livewire\Lead;

use App\Models\Lead;
use App\Models\LeadNote;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Lead $lead;
    public $note;
    public $status;
    public $showDetails = false;
    public $perPage = 5;
    public $totalNotesCount = 0;
    
    public function mount(Lead $lead)
    {
        // Access control
        if (!Auth::user()->isadmin && $lead->user_id !== Auth::id()) {
            abort(403);
        }

        $this->lead = $lead;
        $this->status = $lead->status;
         $this->totalNotesCount = $lead->notes()->count();
    }

    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }

    public function addNote()
    {
        $this->validate([
            'note' => 'required|min:3'
        ]);

        LeadNote::create([
            'lead_id' => $this->lead->id,
            'user_id' => Auth::id(),
            'note' => $this->note
        ]);
        
        $this->note = '';
        $this->totalNotesCount = $this->lead->notes()->count();

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Note added successfully!'
        ]);
    }
    
    public function loadMore()
    {
        $this->perPage += 5;
    }
    
    public function render()
    {
        return view('livewire.lead.show', [
            'notes' => $this->lead->notes()->with('user')->latest()->paginate($this->perPage),
            'lead' => $this->lead->with('user', 'information')->get()
        ]);
    }
}
