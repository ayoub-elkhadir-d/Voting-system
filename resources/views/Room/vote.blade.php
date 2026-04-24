<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote — {{ $room->name }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/js/app.js'])
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
}

body {
    background: #202325  !important;
    color: #2c2418;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 24px 32px;
}


.vote-layout {
    display: flex;
    gap: 32px;
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
    align-items: flex-start;
}

.vote-area {
    flex: 2;
    min-width: 0;
}

.room-log-card {
    flex: 1;
    background: #181a1b;
    border-radius: 28px;
    padding: 24px;
   
    box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    position: sticky;
    top: 24px;
    max-height: calc(100vh - 100px);
    overflow-y: auto;
}

.room-log-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 18px;
    border-bottom: 1px solid #e8dfd7;
    margin-bottom: 20px;
}

.room-log-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #2f92ea;
    letter-spacing: -0.3px;
}

.room-log-icon {
    font-size: 22px;
}

.log-list {
    list-style: none;
    padding: 0;
}

.log-item {
    padding: 12px 0;
    border-bottom: 1px solid #f0eae4;
    font-size: 13px;
    color: #5e5342;
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.log-time {
    font-family: monospace;
    font-size: 11px;
    color: #c9a03d;
    background: #faf5ef;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
    font-weight: 600;
}

.log-message {
    flex: 1;
    line-height: 1.4;
}

.empty-log {
    text-align: center;
    color: #2f92ea;
    padding: 40px 0;
    font-size: 13px;
}

.waiting-screen {
    text-align: center;
    background: #181a1b;
    border-radius: 32px;
    padding: 60px 40px;
    b
    box-shadow: 0 8px 24px rgba(0,0,0,0.04);
}

.waiting-screen h2 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 24px;
    color: #2f92ea;
}

.dots {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #2f92ea;
    animation: bounce 1s ease-in-out infinite;
}
.dot:nth-child(2) { animation-delay: 0.2s; }
.dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes bounce {
    0%,100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.5); opacity: 1; }
}

.vote-card {
    background: #181a1b;
    border-radius: 32px;
    padding: 32px 36px;

    box-shadow: 0 8px 28px rgba(0,0,0,0.05);
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
    font-size: 13px;
    color: #c9a03d;
    background: #faf5ef;
    padding: 5px 16px;
    border-radius: 40px;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.topic-name {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 32px;
    text-align: center;
    color: #3192ea;
    letter-spacing: -0.5px;
}

.choices {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.choice-btn {
    background: #005378;
    
    padding: 22px 0;
    border-radius: 20px;
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.2s ease;
    letter-spacing: -0.2px;
}



.choice-btn:active {
    transform: translateY(0);
    box-shadow: none;
}

.choice-btn.selected {
    background: #253034;
    color: #ffffff;
   }

#submitBtn {
    margin-top: 32px;
    width: 240px;
    padding: 14px;
    border: none;
    border-radius: 60px;
    background: #d4af37;
    color: white;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    display: none;
    margin-left: auto;
    margin-right: auto;
    transition: 0.2s;
    letter-spacing: 0.5px;
}

#submitBtn:hover {
    background: #3192ea;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(201,160,61,0.3);
}

.voted-badge {
    margin-top: 18px;
    background: #e8f5e9;
    color: #2e7d32;
    display: none;
    text-align: center;
    padding: 10px;
    border-radius: 60px;
    font-weight: 600;
    font-size: 14px;
}

.countdown-wrapper {
    background: #4a1e00;
    border-radius: 60px;
    padding: 8px 24px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #3d3630;
}

.countdown-digits {
    font-family: 'Courier New', monospace;
    font-size: 24px;
    font-weight: 800;
    color: #ff7f50;
    background: #2e2a00;
    padding: 4px 18px;
    border-radius: 40px;
    letter-spacing: 2px;
    text-shadow: 0 0 8px rgba(255, 127, 80, 0.3);
}

.warning-countdown {
    background: #351a14;
    border-color: #ff4500;
}

.warning-countdown .countdown-digits {
    color: #ff4500;
}

@keyframes pulseText {
    0%,100% { opacity: 1; }
    50% { opacity: 0.6; }
}

@media (max-width: 900px) {
    body { padding: 20px; }
    .vote-layout { flex-direction: column; }
    .room-log-card { position: relative; width: 100%; max-height: 300px; }
    .choices { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 550px) {
    .choices { grid-template-columns: 1fr; }
    .vote-card { padding: 24px; }
    .topic-name { font-size: 26px; }
}



</style>
</head>
<body>

@include('components.navbar')



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
            <button id="submitBtn">Submit Vote</button>
            <div class="voted-badge" id="votedBadge"> Vote recorded</div>
        </div>
    </div>

    <div class="room-log-card">
        <div class="room-log-header">
            <span class="room-log-icon"></span>
            <h3>Room Activity</h3>
        </div>
        
    </div>
</div>
<script>
const USER_ID = {{ auth()->id() }};
const roomId = {{ $room->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let selectedChoice = null;   // single mode
let selectedChoices = [];    // multiple mode
let hasVoted = false;
let currentTopicId = null;
let currentVoteMode = 'select_one';
let currentMaxChoices = 1;
let countdownInterval = null;
let autoStopTimeout = null;

const waitingScreen = document.getElementById('waitingScreen');
const voteCard = document.getElementById('voteCard');
const topicTitle = document.getElementById('topicName');
const topicLabel = document.getElementById('topicLabel');
const choicesContainer = document.getElementById('choicesContainer');
const submitButton = document.getElementById('submitBtn');
const votedBadge = document.getElementById('votedBadge');
const countdownText = document.getElementById('countdownTimer');
const countdownBox = document.getElementById('countdownWrapper');

function stopTimers() {
    clearInterval(countdownInterval);
    clearTimeout(autoStopTimeout);
}

function toSeconds(timeString) {
    if (!timeString) return 0;

    var parts = timeString.split(':');

    var hours = parseInt(parts[0]);
    var minutes = parseInt(parts[1]);
    var seconds = parseInt(parts[2]);

    return (hours * 3600) + (minutes * 60) + seconds;
}

function formatTime(seconds) {
    var minutes = Math.floor(seconds / 60);
    var secs = seconds - (minutes * 60);

    if (minutes < 10) minutes = '0' + minutes;
    if (secs < 10) secs = '0' + secs;

    return minutes + ':' + secs;
}

function startCountdown(duration, startTime) {
    stopTimers();

    var totalSeconds = toSeconds(duration);
    var now = Math.floor(Date.now() / 1000);
    var remaining = totalSeconds - (now - startTime);

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
        }
    }, 1000);

    autoStopTimeout = setTimeout(function () {
        hideVote();
    }, remaining * 1000);
}

function showVote(topic) {
    stopTimers();

    currentTopicId    = topic.id;
    currentVoteMode   = topic.vote_methode || 'select_one';
    currentMaxChoices = topic.max_choices || 1;
    selectedChoice    = null;
    selectedChoices   = [];
    hasVoted          = false;

    topicLabel.innerText = topic.name;
    topicTitle.innerText = topic.name;
    submitButton.style.display = 'none';
    votedBadge.style.display   = 'none';
    choicesContainer.innerHTML = '';

    // How many votes the user already cast (from server on page load, 0 on live event)
    var alreadyVotedCount    = topic.user_voted_count    || 0;
    var alreadyVotedChoiceIds = topic.user_voted_choice_ids || [];

    // If user already used all their votes, mark as voted immediately
    if (alreadyVotedCount >= currentMaxChoices) {
        hasVoted = true;
    }

    // hint for multiple mode
    var oldHint = document.getElementById('vote-hint');
    if (oldHint) oldHint.remove();
    if (currentVoteMode === 'select_multiple') {
        var hint = document.createElement('p');
        hint.id = 'vote-hint';
        hint.style.cssText = 'font-size:12px;color:#aaa;margin-bottom:12px;text-align:center;';
        hint.innerText = 'Select up to ' + currentMaxChoices + ' choice(s)';
        choicesContainer.before(hint);
    }

    for (var i = 0; i < topic.choices.length; i++) {
        (function (choice) {
            var button = document.createElement('button');
            button.className = 'choice-btn';
            button.innerText = choice.name;
            button.dataset.choiceId = choice.id;

            // Restore previously selected state on page refresh
            if (alreadyVotedChoiceIds.indexOf(choice.id) > -1) {
                button.classList.add('selected');
            }

            // Disable interaction if already voted
            if (hasVoted) {
                button.style.pointerEvents = 'none';
            }

            button.onclick = function () {
                if (hasVoted) return;

                if (currentVoteMode === 'select_one') {
                    document.querySelectorAll('.choice-btn').forEach(b => b.classList.remove('selected'));
                    button.classList.add('selected');
                    selectedChoice = { topicId: topic.id, choiceId: choice.id };
                    submitButton.style.display = 'block';
                } else {
                    var idx = selectedChoices.findIndex(c => c.choiceId === choice.id);
                    if (idx > -1) {
                        selectedChoices.splice(idx, 1);
                        button.classList.remove('selected');
                    } else if (selectedChoices.length < currentMaxChoices) {
                        selectedChoices.push({ topicId: topic.id, choiceId: choice.id });
                        button.classList.add('selected');
                    }
                    submitButton.style.display = selectedChoices.length > 0 ? 'block' : 'none';
                }
            };

            choicesContainer.appendChild(button);
        })(topic.choices[i]);
    }

    // Show voted badge if already voted
    if (hasVoted) {
        votedBadge.style.display = 'block';
    }

    waitingScreen.style.display = 'none';
    voteCard.style.display      = 'block';
    startCountdown(topic.duration, topic.started_at);
}

function hideVote() {
    stopTimers();
    voteCard.style.display = 'none';
    waitingScreen.style.display = 'block';
}

submitButton.onclick = function () {
    if (hasVoted) return;
    if (currentVoteMode === 'select_one' && !selectedChoice) return;
    if (currentVoteMode === 'select_multiple' && selectedChoices.length === 0) return;

    hasVoted = true;
    submitButton.style.display = 'none';
    votedBadge.style.display   = 'block';
    document.querySelectorAll('.choice-btn').forEach(b => b.style.pointerEvents = 'none');

    var toSubmit = currentVoteMode === 'select_one' ? [selectedChoice] : selectedChoices;

    toSubmit.forEach(function(sel) {
        fetch('/rooms/vote/submit', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ topic_id: sel.topicId, choix_id: sel.choiceId, room_id: roomId })
        });
    });
};



@if($activeTopic)

var topic = {
    id: {{ $activeTopic->id }},
    name: @json($activeTopic->name),
    duration: @json($activeTopic->duration),
    started_at: {{ strtotime($activeTopic->started_at) }},
    vote_methode: @json($activeTopic->vote_methode),
    max_choices: {{ $activeTopic->max_choices }},
    choices: @json($activeTopic->choix->map(function($c) {
        return ['id' => $c->id, 'name' => $c->name];
    })),
    user_voted_count: {{ $userVotedCount }},
    user_voted_choice_ids: @json($userVotedChoiceIds)
};

showVote(topic);

@endif

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
        }).listen('.user.removed', (e) => {

            if (e.userId == USER_ID) {
                {{-- console.log("hi") --}}
                    window.location.href = "/rooms/join";
                }
            });
}

listenEvents();
</script>
</body>
</html>