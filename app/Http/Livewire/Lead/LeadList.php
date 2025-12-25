<?php

namespace App\Http\Livewire\Lead;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LeadList extends Component
{
    use WithPagination;

    public $perPage = 25;
    public $status;
    public $user;
    public $date;

    public $statuses = [];

    // protected $queryString = ['status', 'user', 'date'];
    
    public function updating($field)
    {
        $this->resetPage(); // Reset pagination on filter change
    }

    public function render()
    {
        $query = Lead::with(['information', 'user', 'notes']);

        if (!Auth::user()->isadmin) {
            $query->where('user_id', Auth::id());
        }
        
        if ($this->user) {
            $query->where('user_id', $this->user);
        }
        
        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return view('livewire.lead.lead-list', [
            'leads' => $query->latest()->paginate($this->perPage),
            'users' => User::isActive()->orderBy('name')->get()
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

    public function resetFilters()
    {
        $this->status = null;
        $this->date = null;
        $this->user = null;
    }
}
