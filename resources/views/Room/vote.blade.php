<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote — {{ $room->name }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/js/app.js'])
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }

body {
    background:#022C43;
    color:#fff;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:30px 20px;
}

/* waiting screen */
.waiting-screen {
    text-align:center;
}

.waiting-screen h2 {
    font-size:22px;
    font-weight:700;
    margin-bottom:20px;
    color:#FFD700;
}

.dots { display:flex; gap:8px; justify-content:center; }

.dot {
    width:12px; height:12px;
    border-radius:50%;
    background:#FFD700;
    animation:bounce 1s ease-in-out infinite;
}
.dot:nth-child(2) { animation-delay:0.2s; }
.dot:nth-child(3) { animation-delay:0.4s; }

@keyframes bounce {
    0%,100% { transform:scale(1); opacity:1; }
    50%      { transform:scale(1.5); opacity:0.4; }
}

/* vote card */
.vote-card {
    background:#053F5E;
    border-radius:20px;
    padding:40px;
    width:100%;
    max-width:680px;
    box-shadow:0 16px 48px rgba(0,0,0,0.5);
    display:none;
}

.card-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.topic-label { font-size:14px; color:#aaa; }

.topic-name {
    font-size:24px;
    font-weight:bold;
    margin-bottom:25px;
    text-align:center;
}

.choices {
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:20px;
}

.choice-btn {
    background:#6b4a4a;
    border:none;
    padding:25px 0;
    border-radius:12px;
    font-size:22px;
    font-weight:bold;
    color:#fff;
    cursor:pointer;
    transition:0.2s;
}

.choice-btn:hover { transform:scale(1.05); }
.choice-btn.selected { background:#ff2d2d; }

#submitBtn {
    margin-top:30px;
    width:200px;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#FFA500;
    color:#fff;
    font-weight:bold;
    cursor:pointer;
    display:none;
    margin-left:auto;
    margin-right:auto;
}

.voted-badge {
    margin-top:15px;
    color:#FFD700;
    display:none;
    text-align:center;
}
</style>
</head>
<body>

@include('components.navbar')

@php
    // $activeTopic is passed directly from the controller
@endphp

{{-- Waiting screen --}}
<div class="waiting-screen" id="waitingScreen" style="{{ $activeTopic ? 'display:none' : '' }}">
    <h2>⏳ Waiting for the next topic…</h2>
    <div class="dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

{{-- Vote card --}}
<div class="vote-card" id="voteCard" style="{{ $activeTopic ? 'display:block' : 'display:none' }}">
    <div class="card-header">
        <span class="topic-label" id="topicLabel"></span>
    </div>
    <div class="topic-name" id="topicName"></div>
    <div class="choices" id="choicesContainer"></div>
    <button id="submitBtn">Submit</button>
    <div class="voted-badge" id="votedBadge">✔ Vote submitted</div>
</div>

<script>
const roomId = {{ $room->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const colors = ['#6b4a4a','#8b4a4a','#a94444','#c94c4c','#e74c3c','#ff1a1a'];

let selected = null;
let alreadyVoted = false;
let currentTopicId = null;

const waitingScreen = document.getElementById('waitingScreen');
const voteCard = document.getElementById('voteCard');

const topicNameEl = document.getElementById('topicName');
const topicLabelEl = document.getElementById('topicLabel');

const choicesContainer = document.getElementById('choicesContainer');

const submitBtn = document.getElementById('submitBtn');
const votedBadge = document.getElementById('votedBadge');


function showTopic(topic) {
    currentTopicId = topic.id;
    selected = null;
    alreadyVoted = false;

    topicLabelEl.innerText = topic.name;
    topicNameEl.innerText = topic.name;

    submitBtn.style.display = 'none';
    votedBadge.style.display = 'none';

    choicesContainer.innerHTML = '';

    topic.choices.forEach(function(choice, index) {
        const button = document.createElement('button');

        button.className = 'choice-btn';
        button.innerText = choice.name;
        button.style.background = colors[index] || '#022C43';

        button.onclick = function () {
            selectChoice(button, topic.id, choice.id);
        };

        choicesContainer.appendChild(button);
    });

    waitingScreen.style.display = 'none';
    voteCard.style.display = 'block';
}


function showWaiting() {
    voteCard.style.display = 'none';
    waitingScreen.style.display = 'block';
}


function selectChoice(button, topicId, choiceId) {
    if (alreadyVoted) return;

    document.querySelectorAll('.choice-btn').forEach(function(btn) {
        btn.classList.remove('selected');
    });

    button.classList.add('selected');

    selected = {
        topicId: topicId,
        choixId: choiceId
    };

    submitBtn.style.display = 'block';
}


submitBtn.onclick = function () {
    if (!selected || alreadyVoted) return;

    alreadyVoted = true;

    submitBtn.style.display = 'none';
    votedBadge.style.display = 'block';

    document.querySelectorAll('.choice-btn').forEach(function(btn) {
        btn.style.pointerEvents = 'none';
    });

    fetch('/rooms/vote/submit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            topic_id: selected.topicId,
            choix_id: selected.choixId,
            room_id: roomId
        })
    });
};


@if($activeTopic)
showTopic({
    id: {{ $activeTopic->id }},
    name: @json($activeTopic->name),
    choices: @json($activeTopic->choix->map(function($c){
        return ['id' => $c->id, 'name' => $c->name];
    }))
});
@endif


function registerEchoListeners() {
    if (typeof Echo === 'undefined') {
        setTimeout(registerEchoListeners, 100);
        return;
    }

    Echo.channel('room.' + roomId)
        .listen('.topic.started', function(event) {
            showTopic(event.topic);
        })
        .listen('.topic.ended', function() {
            showWaiting();
        });
}

registerEchoListeners();

</script>
</body>
</html>
