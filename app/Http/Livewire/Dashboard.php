<?php

namespace App\Http\Livewire;

use App\Models\Information;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $range = 'today';
    public $fromDate;
    public $toDate;

    public $users = [];
    public $selectedUsers = [];

    public function mount()
    {
        if (Auth::user()->isAdmin()) {
            $this->users = User::isActive()->get();
        }
    }

    private function dateRange()
    {
        switch ($this->range) {
            case 'today':
                return [Carbon::today(), Carbon::now()];
            case '7days':
                return [Carbon::now()->subDays(6), Carbon::now()];
            case '30days':
                return [Carbon::now()->subDays(29), Carbon::now()];
            case 'custom':
                return[Carbon::parse($this->fromDate), Carbon::parse($this->toDate)->endOfDay()];
            default:
                return [Carbon::today(), Carbon::now()];
        }
    }

    public function render()
    {
        [$from, $to] = $this->dateRange();

        // ===== USER FILTER FIX =====
        if (Auth::user()->isAdmin()) {

            if (!empty($this->selectedUsers)) {
                // Force array (important for Livewire 2)
                $userIds = is_array($this->selectedUsers) ? $this->selectedUsers : [$this->selectedUsers];
            } else {
                $userIds = null;
            }
        } else {
            $userIds = [Auth::id()];
        }

        // Approaches
        $query = Information::query();
        if ($userIds !== null) {
            $query->whereIn('user_id', $userIds);
        }
        $approaches = $query->whereBetween('created_at', [$from, $to])->count();

        // Leads
        $leadsQuery = Lead::query();
        if ($userIds !== null){
            $leadsQuery->whereIn('user_id', $userIds);
        }
        $leads = $leadsQuery->whereBetween('created_at', [$from, $to])->count();

        // Lead status counts
        $leadNew = (clone $leadsQuery)->where('status', 'New')->count();
        $leadWon = (clone $leadsQuery)->where('status', 'Won')->count();
        $leadLost = (clone $leadsQuery)->where('status', 'Lost')->count();

        return view('livewire.dashboard', compact(
            'approaches',
            'leads',
            'leadNew',
            'leadWon',
            'leadLost'
        ));
    }

    public function updatedRange()
    {
        if ($this->range !== 'custom') {
            $this->fromDate = null;
            $this->toDate = null;
        }
    }
}
