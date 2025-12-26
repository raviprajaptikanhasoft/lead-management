<?php

namespace App\Http\Livewire\Information;

use App\Models\Information;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InformationList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'informations.created_at';
    public $sortAsc = false;
    public $perPage = 20;
    public $date_from;
    public $date_to;
    public $filter_user;
    public $selectedLead = null;
    public $showModal = false;

    protected $listeners = ['refreshData' => '$refresh'];

    public function render()
    {
        $query = Information::with('user')
            ->leftJoin('users', 'users.id', '=', 'informations.user_id')
            ->whereNotExists(function ($q) {
                $q->selectRaw(1)
                    ->from('leads')
                    ->whereColumn('leads.information_id', 'informations.id');
            })
            ->select('informations.*');

        if (Auth::user()->isadmin == 0) {
            $query->where('informations.user_id', Auth::id());
        }

        // 🔍 SEARCH (safe grouping)
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('informations.text1', 'like', "%{$this->search}%")
                    ->orWhere('informations.text2', 'like', "%{$this->search}%")
                    ->orWhere('informations.text3', 'like', "%{$this->search}%")
                    ->orWhere('informations.text4', 'like', "%{$this->search}%")
                    ->orWhere('informations.text5', 'like', "%{$this->search}%")
                    ->orWhere('informations.text6', 'like', "%{$this->search}%")
                    ->orWhere('informations.text7', 'like', "%{$this->search}%")
                    ->orWhere('informations.text8', 'like', "%{$this->search}%")
                    ->orWhere('informations.text9', 'like', "%{$this->search}%")
                    ->orWhere('users.name', 'like', "%{$this->search}%")
                    ->orWhere('informations.created_at', 'like', "%{$this->search}%");
            });
        }

        if ($this->date_from) {
            $query->whereDate('informations.created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('informations.created_at', '<=', $this->date_to);
        }

        if ($this->filter_user) {
            $query->where('informations.user_id', $this->filter_user);
        }

        $total_records = (clone $query)->count();

        // Sorting + Pagination
        $informations = $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->paginate($this->perPage);

        // Count total items with same filter
        $allUsers = User::select('id', 'name', 'is_active')->orderBy('name')->get();

        return view('livewire.information.information-list', [
            'informations'      => $informations,
            'all_users'  => $allUsers,
            'total_records'  => $total_records,
        ])->layout('layouts.app');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = $field;
            $this->sortAsc = true;
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->date_from = null;
        $this->date_to = null;
        $this->filter_user = null;
        $this->search = '';
    }


    public function getExportData()
    {
        $query = Information::with('user')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('text1', 'like', "%{$this->search}%")
                        ->orWhere('text2', 'like', "%{$this->search}%")
                        ->orWhere('text3', 'like', "%{$this->search}%")
                        ->orWhere('text4', 'like', "%{$this->search}%")
                        ->orWhere('text5', 'like', "%{$this->search}%")
                        ->orWhere('text6', 'like', "%{$this->search}%")
                        ->orWhere('text7', 'like', "%{$this->search}%")
                        ->orWhere('text8', 'like', "%{$this->search}%")
                        ->orWhere('text9', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($u) {
                            $u->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->date_from, fn($q) => $q->whereDate('created_at', '>=', $this->date_from))
            ->when($this->date_to, fn($q) => $q->whereDate('created_at', '<=', $this->date_to))
            ->when(
                Auth::user()->isadmin == 1 && $this->filter_user,
                fn($q) =>
                $q->where('user_id', $this->filter_user)
            );

        $query->whereNotExists(function ($q) {
            $q->selectRaw(1)
                ->from('leads')
                ->whereColumn('leads.information_id', 'informations.id');
        });

        // Normal user gets only own data
        if (Auth::user()->isadmin == 0) {
            $query->where('user_id', Auth::id());
        }

        return $query->orderBy('id', 'DESC')->get();
    }

    public function exportCsv()
    {
        $rows = $this->getExportData();

        $filename = 'leads_' . now()->format('Ymd_His') . '.csv';

        $handle = fopen($filename, 'w');

        // CSV header
        fputcsv($handle, [
            'Lead Name',
            'Designation',
            'Post URL',
            'Description',
            'Company Name',
            'LinkedIn',
            'Email',
            'Phone',
            'Country',
            'Created By',
            'Date'
        ]);

        // Rows
        foreach ($rows as $row) {
            fputcsv($handle, [
                $row->text1,
                $row->text2,
                $row->text3,
                $row->text4,
                $row->text5,
                $row->text6,
                $row->text7,
                $row->text8,
                $row->text9,
                $row->user->name,
                $row->created_at->format('d-m-Y H:i:s'),
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function viewLead($id)
    {
        $this->selectedLead = Information::with('user')->find($id);

        // Optional: If you want to automatically open modal
        $this->dispatchBrowserEvent('openLeadModal');
    }

    public function convertToLead($id)
    {
        $info = Information::findOrFail($id);

        // Prevent duplicate conversion
        if (Lead::where('information_id', $id)->exists()) {
            session()->flash('error', 'Already converted to lead');
            return;
        }

        Lead::create([
            'information_id' => $id,
            'user_id' => Auth::id(),
            // 'status' => 'New',
        ]);
        
        $info->update(['status' => 'Converted']);

        $this->resetPage();

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Converted to Lead successfully'
        ]);
    }
}
