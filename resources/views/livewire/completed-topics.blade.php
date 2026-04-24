<div>
    @if($completed->isNotEmpty())
    <div class="section-label"> Completed Topics</div>

    @foreach($completed as $topic)
    @php $totalVotes = $topic->choix->sum('vote_count'); @endphp

    <div class="topic-card">

        <!-- Normal View -->
        <div class="topic-normal-{{ $topic->id }}">
            <div class="topic-header">
                <div class="topic-name" style="font-size:20px;background:none;color:#1f3a6b;">
                    {{ $topic->name }}
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <span class="badge-completed">✓ Completed</span>
                    <button
                        onclick="Livewire.dispatch('restart-topic', { topicId: {{ $topic->id }} })"
                        style="background:#f39c12;border:none;padding:6px 14px;border-radius:20px;color:#fff;font-size:12px;font-weight:700;cursor:pointer;">
                        ↺ Restart
                    </button>
                </div>
            </div>

            @foreach($topic->choix as $choice)
            @php $pct = $totalVotes > 0 ? round($choice->vote_count / $totalVotes * 100) : 0; @endphp
            <div class="choice-row">
                <div class="choice-label">{{ $choice->name }}</div>
                <div class="bar-wrap">
                    <div class="bar-fill" style="width:{{ $pct }}%;background:#9aaebf;"></div>
                </div>
                <div class="vote-count">
                    {{ $choice->vote_count }}
                    <small style="color:#8895aa;">({{ $pct }}%)</small>
                </div>
            </div>
            @endforeach
        </div>

    </div>
    @endforeach
    @endif
</div>
