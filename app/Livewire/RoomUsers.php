<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\membership;
use App\Events\UserRemoved;
use App\Events\UserAccepted;
class RoomUsers extends Component
{
    public $roomId;

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function mount($roomId)
    {
        $this->roomId = $roomId;
    }

    public function approve($memberId)
    {
    $member = membership::find($memberId);

        if ($member) {
            $member->status = 'accepted';
            $member->save();

            broadcast(new UserAccepted($this->roomId, $member->user_id));

            $this->dispatch('refreshUsers');
        }
    }

    public function remove($memberId)
    {
        $member = membership::find($memberId);
       if ($member) {
            $userId = $member->user_id;
            $member->delete();

            broadcast(new UserRemoved($userId, $this->roomId));

            $this->dispatch('refreshUsers');
        }


    }

    public function render()
    {
        return view('livewire.room-users', [
            'members' => membership::where('room_id', $this->roomId)->get()
        ]);
    }
}
