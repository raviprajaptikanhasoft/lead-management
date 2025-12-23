<?php

namespace App\Http\Livewire\Lead;

use App\Models\Lead;
use App\Models\LeadNote;
use Livewire\Component;

class Show extends Component
{
    public Lead $lead;
    public $note;
    public $status;
    
    public function mount(Lead $lead)
    {
        // Access control
        if (!auth()->user()->isAdmin() && $lead->user_id !== auth()->id()) {
            abort(403);
        }

        $this->lead = $lead;
        $this->status = $lead->status;
    }

    public function addNote()
    {
        $this->validate([
            'note' => 'required|min:3'
        ]);

        LeadNote::create([
            'lead_id' => $this->lead->id,
            'user_id' => auth()->id(),
            'note' => $this->note
        ]);
        
        $this->note = '';

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Note added successfully!'
        ]);
    }
    
    public function render()
    {
        return view('livewire.lead.show', [
            'notes' => $this->lead->notes()->with('user')->get()
        ]);
    }
}
