<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote — {{ $room->name }}</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#022C43;
    color:#fff;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:30px 20px;
}

/* progress bar */
.progress-wrap{
    width:100%;
    max-width:680px;
    margin-bottom:15px;
}

.progress-bar-bg{
    width:100%;
    height:6px;
    background:rgba(255,255,255,0.2);
    border-radius:10px;
    overflow:hidden;
}

.progress-bar-fill{
    height:100%;
    background:#FFD700;
    transition:width 1s linear;
}

/* card */
.vote-card{
    background:#053F5E;
    border-radius:20px;
    padding:40px;
    width:100%;
    max-width:680px;
    box-shadow:0 16px 48px rgba(0,0,0,0.5);
}

/* header */
.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.timer{
    background:#022C43;
    padding:6px 14px;
    border-radius:20px;
    font-weight:bold;
    color:#FFD700;
}

.timer.urgent{
    color:red;
}

.topic-name{
    font-size:24px;
    font-weight:bold;
    margin-bottom:25px;
    text-align:center;
}

/* ✅ GRID LIKE IMAGE */
.choices{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:20px;
}

/* buttons */
.choice-btn{
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

.choice-btn:hover{
    transform:scale(1.05);
}

.choice-btn.selected{
    background:#ff2d2d;
}

/* submit */
#submitBtn{
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

/* voted */
.voted-badge{
    margin-top:15px;
    color:#FFD700;
    display:none;
    text-align:center;
}

/* finish */
.finished-screen{
    text-align:center;
}
</style>
</head>

<body>

@include('components.navbar')

@php
$topicsJson = $topics->map(fn($t) => [
    'id' => $t->id,
    'name' => $t->name,
    'duration_seconds' => $t->duration_seconds,
    'choices' => $t->choix->map(fn($c) => [
        'id'=>$c->id,
        'name'=>$c->name
    ])
])->toJson();
@endphp

<div class="progress-wrap">
    <div class="progress-bar-bg">
        <div class="progress-bar-fill" id="progressBar"></div>
    </div>
</div>

<div class="vote-card" id="voteCard">

    <div class="card-header">
        <span id="topicCounter"></span>
        <div class="timer" id="timer"></div>
    </div>

    <div class="topic-name" id="topicName"></div>

    <div class="choices" id="choicesContainer"></div>

    <button id="submitBtn">Submit</button>

    <div class="voted-badge" id="votedBadge">
        ✔ Vote submitted
    </div>

</div>

<div class="vote-card finished-screen" id="finishedScreen" style="display:none;">
    <h2>🎉 Voting Complete!</h2>
</div>

<script>
const topics = @json(json_decode($topicsJson));
const roomId = {{ $room->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let index = 0;
let time = 0;
let timer = null;
let selected = null;
let alreadyVoted = false;

// elements
const timerEl = document.getElementById('timer');
const topicNameEl = document.getElementById('topicName');
const choicesEl = document.getElementById('choicesContainer');
const counterEl = document.getElementById('topicCounter');
const progressBar = document.getElementById('progressBar');
const submitBtn = document.getElementById('submitBtn');
const votedBadge = document.getElementById('votedBadge');

const colors = ['#6b4a4a','#8b4a4a','#a94444','#c94c4c','#e74c3c','#ff1a1a'];

// load topic
function showTopic(i){
    if(i >= topics.length){
        document.getElementById('voteCard').style.display='none';
        document.getElementById('finishedScreen').style.display='block';
        return;
    }

    let topic = topics[i];

    // reset
    time = topic.duration_seconds;
    selected = null;
    alreadyVoted = false;
    submitBtn.style.display = 'none';
    votedBadge.style.display = 'none';
    choicesEl.innerHTML = '';

    counterEl.innerText = `Topic ${i+1}/${topics.length}`;
    topicNameEl.innerText = topic.name;

    // choices
    topic.choices.forEach((choice, cIndex) => {
        let btn = document.createElement('button');
        btn.className = 'choice-btn';
        btn.innerText = choice.name;
        btn.style.background = colors[cIndex] || '#022C43';

        btn.onclick = () => selectChoice(btn, topic.id, choice.id);

        choicesEl.appendChild(btn);
    });

    startTimer(topic.duration_seconds);
}

// select choice
function selectChoice(btn, topicId, choixId){
    if(alreadyVoted) return;

    document.querySelectorAll('.choice-btn').forEach(b => b.classList.remove('selected'));

    btn.classList.add('selected');

    selected = {
        topicId: topicId,
        choixId: choixId
    };

    submitBtn.style.display = 'block';
}

function startTimer(duration){
    clearInterval(timer);

    timer = setInterval(() => {
        time--;

        timerEl.innerText = time + 's';
        progressBar.style.width = (time / duration) * 100 + '%';

        if(time <= 5){
            timerEl.classList.add('urgent');
        }

        if(time <= 0){
            clearInterval(timer);
            index++;
            showTopic(index);
        }

    }, 1000);
}

submitBtn.onclick = function(){
    if(!selected || alreadyVoted) return;

    alreadyVoted = true;

    submitBtn.style.display = 'none';
    votedBadge.style.display = 'block';

    document.querySelectorAll('.choice-btn').forEach(b=>{
        b.style.pointerEvents='none';
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

// start
showTopic(0);
</script>

</body>
</html>