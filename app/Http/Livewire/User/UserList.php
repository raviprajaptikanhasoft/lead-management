<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $isEdit = false;
    public $userId;
    public $confirmingDelete = false;
    public $deleteUserId;

    public $name, $email, $password, $isadmin = 0, $is_active = 1;

    public function mount()
    {
        abort_unless(Auth::user()->isadmin, 403);
    }


    protected function rules()
    {
        return [
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->isEdit ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.user.user-list', compact('users'));
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('show-user-modal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->userId   = $user->id;
        $this->name     = $user->name;
        $this->email    = $user->email;
        $this->is_active = $user->is_active;
        $this->isadmin = $user->isadmin;
        $this->isEdit   = true;

        $this->resetErrorBag();
        $this->dispatchBrowserEvent('show-user-modal');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name'      => $this->name,
            'email'     => $this->email,
            'is_active' => $this->is_active,
            'isadmin'   => $this->isadmin,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        $this->dispatchBrowserEvent('hide-user-modal');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => $this->isEdit ? 'User updated successfully' : 'User created successfully'
        ]);

        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'is_active', 'isadmin', 'isEdit']);
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'User status updated successfully'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->deleteUserId = $id;
        $this->confirmingDelete = true;
    }

    public function deleteUser()
    {
        User::findOrFail($this->deleteUserId)->delete();

        $this->confirmingDelete = false;
        $this->deleteUserId = null;
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }
}
