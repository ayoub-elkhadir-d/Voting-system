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
    <div class="sidebar-section-label">Pending</div>
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

    <div style="padding: 12px 20px;">
       <a href="{{ route('room.show', [$room->id, 'from' => url()->current()]) }}"
   style="display:block; text-align:center; background:#1a73e8; color:#fff; padding:8px 0; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none;">
    + New Topic
      </a>
    </div>
</div>
