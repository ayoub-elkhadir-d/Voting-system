<div class="sidebar-body">
    @if($active)
    <div class="sidebar-section-label">Active</div>
    <div class="sidebar-item is-active">
        <div class="sidebar-dot dot-active"></div>
        <div class="sidebar-item-name">{{ $active->name }}</div>
        <span class="sidebar-item-badge badge-live">Live</span>
    </div>
    @endif

    @if($pending->isNotEmpty())
    

    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 20px 6px;">
    <div class="sidebar-section-label" style="padding:0;">Pending</div>

    <a href="{{ route('room.show', [$room->id, 'from' => url()->current()]) }}"
       style="background:#1a73e8; color:#fff; padding:4px 10px; border-radius:8px; font-size:11px; font-weight:700; text-decoration:none;">
         + New Topic
    </a>
</div>
    @foreach($pending as $pt)
    <div class="sidebar-item is-pending">
        <div class="sidebar-dot dot-pending"></div>
        <div class="sidebar-item-name">{{ $pt->name }}</div>
        @if(!$active)
        <form action="/rooms/{{ $room->id }}/topic/{{ $pt->id }}/start" method="POST">
            @csrf
            <button type="submit" class="sidebar-start-btn">Start</button>
        </form>
        @else
        <span class="sidebar-item-badge badge-pending">Pending</span>
        @endif
    </div>
    @endforeach
    @endif

</div>
