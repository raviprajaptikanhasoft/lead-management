<?php

namespace App\Http\Livewire\Information;

use App\Models\Information;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddInformation extends Component
{
    public $text1, $text2, $text3, $text4, $text5, $text6, $text7, $text8, $text9;
    public array $countries = [];

    protected $rules = [
        'text1' => 'required',
        'text2' => 'required',
        'text3' => 'required|url',
        'text4' => 'required',
        'text5' => 'nullable',
        'text6' => 'nullable',
        'text7' => 'nullable|email',
        'text8' => 'nullable',
        'text9' => 'nullable',
    ];

    protected $messages = [
        'text1.required' => 'Please enter the lead name.',
        'text2.required' => 'Designation is required.',
        'text3.required' => 'Post URL cannot be empty.',
        'text3.url'      => 'Post URL must be a valid link.',
        'text4.required' => 'Description is required.',
        'text7.email'    => 'Please enter a valid email address.',
    ];

    protected $listeners = ['openAddLeadModal' => 'openModal', 'resetLeadForm'    => 'resetForm',];

    public function mount()
    {
        $path = public_path('data/countries.json');

        if (file_exists($path)) {
            $this->countries = json_decode(file_get_contents($path), true);
        }
    }


    public function openModal()
    {
        $this->resetForm();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('open-add-lead-modal');
    }

    public function resetForm()
    {
        $this->reset([
            'text1','text2','text3','text4',
            'text5','text6','text7','text8','text9'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function saveLead()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // just rethrow - Livewire will show errors
            throw $e;
        }

        Information::create([
            'user_id' => Auth::id(),
            'text1'   => $this->text1,
            'text2'   => $this->text2,
            'text3'   => $this->text3,
            'text4'   => $this->text4,
            'text5'   => $this->text5,
            'text6'   => $this->text6,
            'text7'   => $this->text7,
            'text8'   => $this->text8,
            'text9'   => $this->text9,
        ]);

        // Close modal
        $this->dispatchBrowserEvent('close-add-lead-modal');

        $this->resetForm();

        // Refresh the lead listing
        $this->emitUp('refreshData');
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Information added successfully!'
        ]);
        // session()->flash('status', 'Lead added successfully!');
    }

    public function updated($field)
    {
        $this->resetErrorBag($field);
    }

    
    public function render()
    {
        return view('livewire.information.add-information');
    }
}
