<div class="activity-card">
    <h3>Room Activity</h3>

    <ul class="log-list">
        @foreach($members as $m)
            <li class="log-item" style="align-items:center; gap:10px;">

                <span>
                    {{ $m->username }}

                    @if($m->status === 'pending')
                        <span style="color:#f39c12;">(pending)</span>
                    @else
                        joined
                    @endif
                </span>

                <span class="log-time">
                    {{ $m->created_at->format('H:i') }}
                </span>

                @if($m->status === 'pending')
                    <div style="display:flex; gap:6px; margin-left:auto;">

                        {{-- Accept --}}
                        <button
                            wire:click="approve({{ $m->id }})"
                            style="background:#2ecc71;border:none;padding:4px 10px;border-radius:6px;color:#fff;font-size:11px;">
                            ✔
                        </button>

                        {{-- Decline --}}
                        <button
                            wire:click="decline({{ $m->id }})"
                            style="background:#e74c3c;border:none;padding:4px 10px;border-radius:6px;color:#fff;font-size:11px;">
                            ✖
                        </button>

                    </div>
                @endif

            </li>
        @endforeach
    </ul>
</div>