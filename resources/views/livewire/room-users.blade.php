<div>
@foreach($members as $member)
<div class="sidebar-item" style="justify-content: space-between;">

    <div style="display:flex; align-items:center; gap:10px;">
        <div class="user-avatar">
            {{ strtoupper(substr($member->username ?? 'U', 0, 1)) }}
        </div>

        <div class="user-info">
            <div class="user-name">{{ $member->username }}</div>

            @if($member->status === 'pending')
                <div style="font-size:12px; color:#f39c12;">pending</div>
            @else
                <div style="font-size:12px; color:#2ecc71;">accepted</div>
            @endif
        </div>
    </div>

    <div style="display:flex; gap:6px;">

        @if($member->status !== 'accepted')
        <button wire:click="approve({{ $member->id }})"
            style="background:#2ecc71;border:none;padding:5px 10px;border-radius:6px;color:#fff;">
            ✔
        </button>
        @endif

        <button wire:click="remove({{ $member->id }})"
            class="remove-btn">
            ✕
        </button>

    </div>

</div>
@endforeach
</div>