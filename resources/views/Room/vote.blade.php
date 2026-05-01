<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote — {{ $room->name }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/js/app.js'])
<style>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }

body {
    background: #f5f7fb;
    color: #1a1a2e;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 24px 32px;
}

.vote-layout {
    display: flex;
    gap: 24px;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
    align-items: flex-start;
}

.vote-area { flex: 2; min-width: 0; }

.room-log-card {
    flex: 1;
    background: #fff;
    border-radius: 20px;
    padding: 24px;
    border: 1px solid #e6eaf0;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    position: sticky;
    top: 24px;
    max-height: calc(100vh - 100px);
    overflow-y: auto;
}

.room-log-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 16px;
    border-bottom: 1px solid #e6eaf0;
    margin-bottom: 16px;
}

.room-log-header h3 {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
}

.room-log-icon { font-size: 18px; color: #1a73e8; }

.log-list { list-style: none; padding: 0; }

.log-item {
    padding: 10px 0;
    border-bottom: 1px solid #f0f4fc;
    font-size: 13px;
    color: #444;
    display: flex;
    gap: 10px;
    align-items: flex-start;
}

.log-time {
    font-family: monospace;
    font-size: 11px;
    color: #1a73e8;
    background: #e3f2fd;
    padding: 2px 8px;
    border-radius: 20px;
    white-space: nowrap;
    font-weight: 600;
}

.log-message { flex: 1; line-height: 1.4; }

.empty-log {
    text-align: center;
    color: #aaa;
    padding: 40px 0;
    font-size: 13px;
}

.waiting-screen {
    text-align: center;
    background: #fff;
    border-radius: 24px;
    padding: 60px 40px;
    border: 1px solid #e6eaf0;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}

.waiting-screen h2 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 24px;
    color: #1a1a2e;
}

.dots { display: flex; gap: 10px; justify-content: center; }

.dot {
    width: 11px;
    height: 11px;
    border-radius: 50%;
    background: #1a73e8;
    animation: bounce 1s ease-in-out infinite;
}
.dot:nth-child(2) { animation-delay: 0.2s; }
.dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes bounce {
    0%,100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.5); opacity: 1; }
}

.vote-card {
    background: #fff;
    border-radius: 24px;
    padding: 32px 36px;
    border: 1px solid #e6eaf0;
    box-shadow: 0 8px 28px rgba(0,0,0,0.07);
    display: none;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}

.topic-label {
    font-size: 12px;
    color: #1565c0;
    background: #e3f2fd;
    padding: 5px 16px;
    border-radius: 40px;
    font-weight: 700;
    letter-spacing: 0.3px;
}

.topic-name {
    font-size: 30px;
    font-weight: 800;
    margin-bottom: 28px;
    text-align: center;
    background: linear-gradient(135deg, #1a2a4f, #1a73e8);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    letter-spacing: -0.5px;
}

.choices {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.choice-btn {
    position: relative;
    background: #f0f4fc;
    border: 2px solid #e6eaf0;
    padding: 18px 20px;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: left;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    min-height: 58px;
}

/* the fill bar behind the button text */
.choice-btn .bar-bg {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0%;
    background: #e3f2fd;
    border-radius: 12px;
    transition: width 0.5s ease;
    z-index: 0;
}

.choice-btn.my-vote .bar-bg  { background: #c8e6c9; }

.choice-btn .choice-text {
    position: relative;
    z-index: 1;
    flex: 1;
}

.choice-btn .choice-pct {
    position: relative;
    z-index: 1;
    font-size: 13px;
    font-weight: 700;
    color: #1a73e8;
    min-width: 40px;
    text-align: right;
    display: none;
}

.choice-btn.my-vote .choice-pct { color: #2e7d32; }

.choice-btn:hover {
    border-color: #1a73e8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(26,115,232,0.12);
}

.choice-btn:active { transform: translateY(0); box-shadow: none; }

.choice-btn.selected {
    border-color: #1a73e8;
    background: #e8f0fe;
    color: #1a1a2e;
}

.choice-btn.my-vote {
    border-color: #2e7d32;
    pointer-events: none;
}

#submitBtn {
    margin-top: 28px;
    width: 220px;
    padding: 13px;
    border: none;
    border-radius: 60px;
    background: #1a73e8;
    color: white;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    display: none;
    margin-left: auto;
    margin-right: auto;
    transition: 0.2s;
    letter-spacing: 0.3px;
}

#submitBtn:hover {
    background: #1558b0;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(26,115,232,0.3);
}

.voted-badge {
    margin-top: 16px;
    background: #e8f5e9;
    color: #2e7d32;
    display: none;
    text-align: center;
    padding: 10px;
    border-radius: 60px;
    font-weight: 600;
    font-size: 14px;
}

#cancelBtn {
    margin-top: 10px;
    width: 220px;
    padding: 11px;
    border: 2px solid #e74c3c;
    border-radius: 60px;
    background: #fff;
    color: #e74c3c;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    display: none;
    margin-left: auto;
    margin-right: auto;
    transition: 0.2s;
}

#cancelBtn:hover {
    background: #ffeaea;
    transform: translateY(-2px);
}

.countdown-wrapper {
    background: linear-gradient(145deg, #fff0e6, #ffe6d5);
    border-radius: 60px;
    padding: 7px 20px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 1px solid rgba(255,87,34,0.4);
    box-shadow: 0 4px 12px rgba(255,87,34,0.2);
}

.countdown-digits {
    font-family: 'SF Mono', 'Fira Code', monospace;
    font-size: 22px;
    font-weight: 800;
    color: #d84315;
    letter-spacing: 1px;
}

.warning-countdown {
    background: linear-gradient(145deg, #ffded5, #ffc8b8);
    border-color: #ff5722;
    box-shadow: 0 4px 12px rgba(255,87,34,0.4);
}

.warning-countdown .countdown-digits { color: #bf360c; }

/* ── Page title ── */
.page-title {
    text-align: center;
    font-size: 36px;
    font-weight: 800;
    color: #1a1a2e;
    padding: 28px 0 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    letter-spacing: -0.5px;
}
.page-title i { color: #1a73e8; font-size: 32px; }
.page-title .blue { color: #1a73e8; }

/* ── Cast Your Vote label ── */
.cast-label {
    text-align: center;
    font-size: 28px;
    font-weight: 800;
    color: #1a1a2e;
    margin: 20px 0 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    letter-spacing: -0.3px;
}
.cast-label i {
    font-size: 26px;
    color: #1a73e8;
}

/* ── Participants panel ── */
.member-count-badge {
    margin-left: auto;
    background: #e3f2fd;
    color: #1565c0;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
}
.member-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a73e8, #4a9eff);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}
.online-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #2e7d32;
    flex-shrink: 0;
    margin-left: auto;
}

/* ── Room info bar ── */
.room-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    max-width: 1200px;
    margin: 0 auto 20px;
    width: 100%;
}
.room-bar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.room-bar-icon {
    width: 38px;
    height: 38px;
    background: #e3f2fd;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #1a73e8;
}
.room-bar-name {
    font-size: 16px;
    font-weight: 800;
    color: #1a1a2e;
}
.room-bar-right {
    display: flex;
    align-items: center;
    gap: 10px;
}
.room-bar-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 40px;
}
.badge-members { background: #e8f5e9; color: #2e7d32; }
.badge-progress { background: #e3f2fd; color: #1565c0; }

/* ── Vote result bars (shown after voting) ── */
.result-bars { display: none; }

@media (max-width: 900px) {
    body { padding: 16px; }
    .vote-layout { flex-direction: column; }
    .room-log-card { position: relative; width: 100%; max-height: 280px; }
}

@media (max-width: 550px) {
    .vote-card { padding: 22px; }
    .topic-name { font-size: 24px; }
}
</style>
</head>
<body>

@include('components.navbar')

<!-- Page title -->
<div class="page-title">
    <i class="fa-solid fa-check-to-slot"></i>
   Cast <span class="blue">Your</span>  Vote
</div>

<!-- Room info bar -->
<div class="room-bar">
    <div class="room-bar-left">
        <div class="room-bar-icon"><i class="fa-solid fa-door-open"></i></div>
        <span class="room-bar-name">{{ $room->name }}</span>
    </div>
    <div class="room-bar-right">
        <span class="room-bar-badge badge-members">
            <i class="fa-solid fa-users"></i> {{ $memberCount }} participants
        </span>
        <span class="room-bar-badge badge-progress">
            <i class="fa-solid fa-list-check"></i>
            {{ $completedTopics }} / {{ $totalTopics }} topics done
        </span>
    </div>
</div>
<div class="vote-layout">
    <div class="vote-area">
        <div class="waiting-screen" id="waitingScreen" style="{{ $activeTopic ? 'display:none' : '' }}">
            <h2> Waiting for the next topic…</h2>
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>

        <div class="vote-card" id="voteCard" style="{{ $activeTopic ? 'display:block' : 'display:none' }}">
            <div class="card-header">
                <span class="topic-label" id="topicLabel"></span>
                <div class="countdown-wrapper" id="countdownWrapper">
                    
                    <span id="countdownTimer" class="countdown-digits">00:00</span>
                </div>
            </div>
            <div class="topic-name" id="topicName"></div>
            <div class="choices" id="choicesContainer"></div>
            <div class="result-bars" id="resultBars"></div>
            <button id="submitBtn">Submit Vote</button>
            <div class="voted-badge" id="votedBadge">✓ Vote recorded</div>
            <button id="cancelBtn">✕ Change Vote</button>
        </div>
    </div>

    <div class="room-log-card">
        <div class="room-log-header">
            <span class="room-log-icon"><i class="fa-solid fa-users"></i></span>
            <h3>Participants</h3>
            <span id="memberCountBadge" class="member-count-badge">{{ $memberCount }}</span>
        </div>
        <ul class="log-list" id="memberList">
            @foreach($members as $m)
            <li class="log-item" data-user-id="{{ $m->user_id }}">
                <div class="member-avatar">{{ strtoupper(substr($m->username, 0, 1)) }}</div>
                <span class="log-message">{{ $m->username }}</span>
                <span class="online-dot"></span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<script>

// ─── Page variables ───────────────────────────────────────────────────────────

var USER_ID    = {{ auth()->id() }};
var roomId     = {{ $room->id }};
var csrfToken  = document.querySelector('meta[name="csrf-token"]').content;

// what the user selected
var selectedChoice  = null;  // used in single-choice mode
var selectedChoices = [];    // used in multiple-choice mode

// state flags
var hasVoted        = false;
var currentTopicId  = null;
var currentVoteMode = 'select_one';
var currentMaxChoices = 1;

// timer references so we can stop them later
var countdownInterval = null;
var autoStopTimeout   = null;

// ─── Get HTML elements ────────────────────────────────────────────────────────

var waitingScreen    = document.getElementById('waitingScreen');
var voteCard         = document.getElementById('voteCard');
var topicTitle       = document.getElementById('topicName');
var topicLabel       = document.getElementById('topicLabel');
var choicesContainer = document.getElementById('choicesContainer');
var resultBars       = document.getElementById('resultBars');
var submitButton     = document.getElementById('submitBtn');
var cancelButton     = document.getElementById('cancelBtn');
var votedBadge       = document.getElementById('votedBadge');
var countdownText    = document.getElementById('countdownTimer');
var countdownBox     = document.getElementById('countdownWrapper');


// ─── Timer helpers ────────────────────────────────────────────────────────────

// Stop any running timers
function stopTimers() {
    clearInterval(countdownInterval);
    clearTimeout(autoStopTimeout);
}

function toSeconds(timeString) {
    if (!timeString) return 0;
    var parts   = timeString.split(':');
    var hours   = parseInt(parts[0]);
    var minutes = parseInt(parts[1]);
    var seconds = parseInt(parts[2]);
    return (hours * 3600) + (minutes * 60) + seconds;
}

function formatTime(totalSeconds) {
    var minutes = Math.floor(totalSeconds / 60);
    var seconds = totalSeconds % 60;
    if (minutes < 10) minutes = '0' + minutes;
    if (seconds < 10) seconds = '0' + seconds;
    return minutes + ':' + seconds;
}

function startCountdown(duration, startTime) {
    stopTimers();

    var totalSeconds = toSeconds(duration);
    var now          = Math.floor(Date.now() / 1000);
    var remaining    = totalSeconds - (now - startTime);

    if (remaining < 0) remaining = 0;

    countdownText.innerText = formatTime(remaining);

    countdownInterval = setInterval(function () {
        remaining--;

        if (remaining < 0) {
            clearInterval(countdownInterval);
            return;
        }

        countdownText.innerText = formatTime(remaining);

        if (remaining <= 5) {
            countdownBox.classList.add('warning-countdown');
            cancelButton.style.display = 'none';
        }
    }, 1000);

    // auto-hide the vote card when time is up
    autoStopTimeout = setTimeout(function () {
        hideVote();
    }, remaining * 1000);
}


// Build result bars from a choices array [{id, name, votes}]
function showResultBars(choices, myChoiceIds) {
    // calculate total
    var total = 0;
    for (var i = 0; i < choices.length; i++) {
        total += choices[i].votes;
    }

    // update each button's bar and percentage
    for (var i = 0; i < choices.length; i++) {
        var btn = choicesContainer.querySelector('[data-choice-id="' + choices[i].id + '"]');
        if (!btn) continue;

        var pct    = total > 0 ? Math.round((choices[i].votes / total) * 100) : 0;
        var isMine = myChoiceIds.indexOf(choices[i].id) > -1;

        var barBg  = btn.querySelector('.bar-bg');
        var pctEl  = btn.querySelector('.choice-pct');

        if (barBg)  barBg.style.width = pct + '%';
        if (pctEl) {
            pctEl.innerText    = pct + '%';
            pctEl.style.display = 'block';
        }

        // green for my vote, blue for others
        if (isMine) {
            btn.classList.add('my-vote');
        }
    }
}

// Update bars live when a WebSocket vote event arrives
function updateResultBars(choices) {
    var total = 0;
    for (var i = 0; i < choices.length; i++) {
        total += choices[i].votes;
    }

    for (var i = 0; i < choices.length; i++) {
        var btn = choicesContainer.querySelector('[data-choice-id="' + choices[i].id + '"]');
        if (!btn) continue;

        var pct   = total > 0 ? Math.round((choices[i].votes / total) * 100) : 0;
        var barBg = btn.querySelector('.bar-bg');
        var pctEl = btn.querySelector('.choice-pct');

        if (barBg)  barBg.style.width  = pct + '%';
        if (pctEl) {
            pctEl.innerText     = pct + '%';
            pctEl.style.display = 'block';
        }
    }
}

function hideResultBars() {
    // reset all bars and percentages
    var buttons = document.querySelectorAll('.choice-btn');
    for (var i = 0; i < buttons.length; i++) {
        var barBg = buttons[i].querySelector('.bar-bg');
        var pctEl = buttons[i].querySelector('.choice-pct');
        if (barBg)  barBg.style.width  = '0%';
        if (pctEl)  pctEl.style.display = 'none';
        buttons[i].classList.remove('my-vote');
    }
}


// ─── Choice button helpers ────────────────────────────────────────────────────

function clearAllSelections() {
    var buttons = document.querySelectorAll('.choice-btn');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('selected');
    }
}

function disableAllChoices() {
    var buttons = document.querySelectorAll('.choice-btn');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].style.pointerEvents = 'none';
    }
}

function enableAllChoices() {
    var buttons = document.querySelectorAll('.choice-btn');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].style.pointerEvents = '';
    }
}

function findChoiceIndex(choiceId) {
    for (var i = 0; i < selectedChoices.length; i++) {
        if (selectedChoices[i].choiceId === choiceId) {
            return i;
        }
    }
    return -1;
}


// ─── Show / Hide vote card ────────────────────────────────────────────────────

function showVote(topic) {
    stopTimers();

    
    currentTopicId    = topic.id;
    currentVoteMode   = topic.vote_methode || 'select_one';
    currentMaxChoices = topic.max_choices  || 1;

    selectedChoice  = null;
    selectedChoices = [];
    hasVoted        = false;

  
    topicLabel.innerText = topic.name;
    topicTitle.innerText = topic.name;

   
    submitButton.style.display = 'none';
    cancelButton.style.display = 'none';
    votedBadge.style.display   = 'none';

    choicesContainer.innerHTML = '';
    hideResultBars();

    var alreadyVotedCount     = topic.user_voted_count     || 0;
    var alreadyVotedChoiceIds = topic.user_voted_choice_ids || [];

    // check if user already voted for this topic
    if (alreadyVotedCount >= currentMaxChoices) {
        hasVoted = true;
    }

    // show hint for multiple-choice mode
    var oldHint = document.getElementById('vote-hint');
    if (oldHint) oldHint.remove();

    if (currentVoteMode === 'select_multiple') {
        var hint = document.createElement('p');
        hint.id = 'vote-hint';
        hint.style.cssText = 'font-size:12px;color:#aaa;margin-bottom:12px;text-align:center;';
        hint.innerText = 'Select up to ' + currentMaxChoices + ' choice(s)';
        choicesContainer.before(hint);
    }

    // build one button per choice
    for (var i = 0; i < topic.choices.length; i++) {
        var choice = topic.choices[i];
        var button = document.createElement('button');
        button.className = 'choice-btn';
        button.dataset.choiceId = choice.id;
        button.dataset.topicId  = topic.id;

        // inner bar background (fills based on vote %)
        var barBg = document.createElement('div');
        barBg.className = 'bar-bg';

        // choice name text
        var choiceText = document.createElement('span');
        choiceText.className = 'choice-text';
        choiceText.innerText = choice.name;

        // percentage label (hidden until voted)
        var choicePct = document.createElement('span');
        choicePct.className = 'choice-pct';
        choicePct.style.display = 'none';

        button.appendChild(barBg);
        button.appendChild(choiceText);
        button.appendChild(choicePct);

        // highlight if user already voted for this choice
        if (alreadyVotedChoiceIds.indexOf(choice.id) > -1) {
            button.classList.add('selected');
        }

        // lock buttons if already voted
        if (hasVoted) {
            button.style.pointerEvents = 'none';
        }

        button.onclick = function () {
            if (hasVoted) return;

            var clickedChoiceId = parseInt(this.dataset.choiceId);
            var clickedTopicId  = parseInt(this.dataset.topicId);

            if (currentVoteMode === 'select_one') {
                clearAllSelections();
                this.classList.add('selected');
                selectedChoice = { topicId: clickedTopicId, choiceId: clickedChoiceId };
                submitButton.style.display = 'block';

            } else {
                var idx = findChoiceIndex(clickedChoiceId);

                if (idx > -1) {
                    selectedChoices.splice(idx, 1);
                    this.classList.remove('selected');
                } else if (selectedChoices.length < currentMaxChoices) {
                    selectedChoices.push({ topicId: clickedTopicId, choiceId: clickedChoiceId });
                    this.classList.add('selected');
                }

                if (selectedChoices.length > 0) {
                    submitButton.style.display = 'block';
                } else {
                    submitButton.style.display = 'none';
                }
            }
        };

        choicesContainer.appendChild(button);
    }


    if (hasVoted) {
        votedBadge.style.display   = 'block';
        cancelButton.style.display = 'block';
        // show bars at 0% — will update via WebSocket
        var barsData = [];
        for (var j = 0; j < topic.choices.length; j++) {
            barsData.push({ id: topic.choices[j].id, name: topic.choices[j].name, votes: 0 });
        }
        showResultBars(barsData, alreadyVotedChoiceIds);
    }

    waitingScreen.style.display = 'none';
    voteCard.style.display      = 'block';

    startCountdown(topic.duration, topic.started_at);
}

function hideVote() {
    stopTimers();
    cancelButton.style.display  = 'none';
    voteCard.style.display      = 'none';
    waitingScreen.style.display = 'block';
}


// ─── Submit vote ──────────────────────────────────────────────────────────────

submitButton.onclick = function () {
    if (hasVoted) return;
    if (currentVoteMode === 'select_one'      && !selectedChoice)              return;
    if (currentVoteMode === 'select_multiple' && selectedChoices.length === 0) return;

    hasVoted = true;
    submitButton.style.display = 'none';
    votedBadge.style.display   = 'block';
    cancelButton.style.display = 'block';
    disableAllChoices();

    // collect what was voted
    var toSubmit   = [];
    var myVotedIds = [];
    if (currentVoteMode === 'select_one') {
        toSubmit.push(selectedChoice);
        myVotedIds.push(selectedChoice.choiceId);
    } else {
        for (var i = 0; i < selectedChoices.length; i++) {
            toSubmit.push(selectedChoices[i]);
            myVotedIds.push(selectedChoices[i].choiceId);
        }
    }

   
    var allButtons   = document.querySelectorAll('.choice-btn');
    var choicesForBars = [];
    for (var i = 0; i < allButtons.length; i++) {
        choicesForBars.push({
            id:    parseInt(allButtons[i].dataset.choiceId),
            name:  allButtons[i].querySelector('.choice-text').innerText,
            votes: 0
        });
    }
    showResultBars(choicesForBars, myVotedIds);

    // send each vote to the server
    for (var i = 0; i < toSubmit.length; i++) {
        var sel = toSubmit[i];
        fetch('/rooms/vote/submit', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ topic_id: sel.topicId, choix_id: sel.choiceId, room_id: roomId })
        });
    }
};


// ─── Cancel vote ──────────────────────────────────────────────────────────────

cancelButton.onclick = function () {
    fetch('/rooms/vote/cancel', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ topic_id: currentTopicId, room_id: roomId })
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        if (data.status !== 'cancelled') return;

        // reset state
        hasVoted        = false;
        selectedChoice  = null;
        selectedChoices = [];

        // hide vote result UI
        votedBadge.style.display   = 'none';
        cancelButton.style.display = 'none';
        submitButton.style.display = 'none';

        // clear selections, re-enable buttons, hide result bars
        clearAllSelections();
        enableAllChoices();
        hideResultBars();
    });
};


// ─── Load active topic on page load ──────────────────────────────────────────

@if($activeTopic)
var topic = {
    id:                   {{ $activeTopic->id }},
    name:                 @json($activeTopic->name),
    duration:             @json($activeTopic->duration),
    started_at:           {{ strtotime($activeTopic->started_at) }},
    vote_methode:         @json($activeTopic->vote_methode),
    max_choices:          {{ $activeTopic->max_choices }},
    choices:              @json($activeTopic->choix->map(function($c) { return ['id' => $c->id, 'name' => $c->name]; })),
    user_voted_count:     {{ $userVotedCount }},
    user_voted_choice_ids: @json($userVotedChoiceIds)
};
showVote(topic);
@endif


// ─── Real-time member list ───────────────────────────────────────────────────

var memberList        = document.getElementById('memberList');
var memberCountBadge  = document.getElementById('memberCountBadge');

// add a new member row to the list
function addMemberToList(userId, username) {
    // don't add duplicates
    if (memberList.querySelector('[data-user-id="' + userId + '"]')) return;

    var li = document.createElement('li');
    li.className = 'log-item';
    li.dataset.userId = userId;

    var avatar = document.createElement('div');
    avatar.className = 'member-avatar';
    avatar.innerText = username.charAt(0).toUpperCase();

    var name = document.createElement('span');
    name.className = 'log-message';
    name.innerText = username;

    var dot = document.createElement('span');
    dot.className = 'online-dot';

    li.appendChild(avatar);
    li.appendChild(name);
    li.appendChild(dot);
    memberList.appendChild(li);

    // update the count badge
    memberCountBadge.innerText = memberList.querySelectorAll('.log-item').length;
}

// remove a member row from the list
function removeMemberFromList(userId) {
    var row = memberList.querySelector('[data-user-id="' + userId + '"]');
    if (row) row.remove();
    memberCountBadge.innerText = memberList.querySelectorAll('.log-item').length;
}


// ─── Real-time events (WebSocket) ─────────────────────────────────────────────

function listenEvents() {
    if (typeof Echo === 'undefined') {
        setTimeout(listenEvents, 100);
        return;
    }

    Echo.channel('room.' + roomId)
        .listen('.topic.started', function (e) {
            showVote(e.topic);
        })
        .listen('.topic.ended', function () {
            hideVote();
        })
        .listen('.vote.updated', function (e) {
            // update result bars live if user already voted
            if (hasVoted) {
                updateResultBars(e.choices);
            }
        })
        .listen('.user.joined', function (e) {
            addMemberToList(e.userId, e.username);
        })
        .listen('.user.left', function (e) {
            removeMemberFromList(e.userId);
        })
        .listen('.user.removed', function (e) {
            if (e.userId == USER_ID) {
                window.location.href = '/rooms/join';
            } else {
                removeMemberFromList(e.userId);
            }
        });
}

listenEvents();

</script>
</body>
</html>