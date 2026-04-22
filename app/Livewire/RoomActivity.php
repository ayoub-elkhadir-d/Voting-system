<?php
use Livewire\Component;
use App\Models\membership;
use Livewire\Attributes\On;
use App\Events\UserAccepted;
use App\Events\UserRemoved;

class RoomActivity extends Component
{
    public $roomId;

    public function approve($memberId)
    {
        $member = membership::find($memberId);

        if ($member) {
            $member->status = 'accepted';
            $member->save();

            broadcast(new UserAccepted($this->roomId, $member->user_id));

            $this->dispatch('refresh-activity');
        }
    }

    public function decline($memberId)
    {
        $member = membership::find($memberId);

        if ($member) {
            $userId = $member->user_id;
            $member->delete();

            broadcast(new UserRemoved($userId, $this->roomId));

            $this->dispatch('refresh-activity');
        }
    }

    #[On('refresh-activity')]
    public function refreshActivity()
    {
        // غير refresh component
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.room-activity', [
            'members' => membership::where('room_id', $this->roomId)->get()
        ]);
    }
}