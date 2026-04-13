<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Topics & Voting</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI';}

body{
    background:linear-gradient(135deg,#0f0f0f,#1f1f1f);
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

/* WRAPPER */
.wrapper{
    width:1150px;
}

/* ALERT */
.alert{
    background:#00C853;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
    font-weight:bold;
}

/* CONTAINER */
.container{
    display:flex;
    gap:30px;
}

/* CARDS */
.card{
    background:#121212;
    padding:25px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.5);
}

.left{width:65%;}
.right{width:35%;}

/* INPUT */
.label{
    color:#FCA311;
    margin:12px 0 6px;
    display:block;
    font-size:14px;
}

.input{
    width:100%;
    background:#1B1B1B;
    border:none;
    padding:12px;
    border-radius:10px;
    color:#fff;
    outline:none;
    transition:0.2s;
}

.input:focus{
    border:1px solid #FCA311;
}

/* BUTTONS */
button{
    border:none;
    padding:12px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
    transition:0.2s;
}

.primary{
    background:#FCA311;
    width:100%;
}

.primary:hover{background:#ffb733;}

.success{
    background:#00C853;
    width:100%;
    margin-bottom:15px;
}

.success:hover{background:#00e676;}

.add-btn{
    background:#333;
    color:#fff;
    padding:8px 12px;
    margin-top:10px;
}

.add-btn:hover{background:#444;}

.remove-btn{
    background:#d32f2f;
    color:#fff;
    padding:8px 10px;
}

.remove-btn:hover{background:#ff5252;}

/* CHOICES */
#choices-container{
    max-height:200px;
    overflow-y:auto;
    margin-top:5px;
}

.choice-item{
    display:flex;
    gap:10px;
    margin-bottom:8px;
}

/* TOPICS */
.question{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#1B1B1B;
    padding:12px;
    border-radius:10px;
    margin-bottom:10px;
    transition:0.2s;
}

.question:hover{
    background:#252525;
    transform:scale(1.02);
}

.q-number{
    background:#333;
    padding:5px 10px;
    border-radius:6px;
}

.time{
    background:#FCA311;
    color:#000;
    padding:4px 8px;
    border-radius:6px;
}

/* TITLE */
.title{
    margin-bottom:10px;
    color:#FCA311;
}

/* NAVBAR FIX */
.navbar{
    position:absolute;
    top:0;
    width:100%;
}
</style>

</head>

<body>

@include('components.navbar')

<div class="wrapper">

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="container">

        <!-- LEFT -->
        <div class="card left">

            <h3 class="title">Create Topic</h3>

            <form method="POST" action="/rooms/{{$data->id}}/topic">
                @csrf

                <label class="label">Topic</label>
                <input type="text" name="topic_name" class="input" placeholder="Enter topic">

                <label class="label">Vote Method</label>
                <select name="vote_method" class="input" onchange="changeMethod(this.value)">
                    <option value="custom">Custom</option>
                    <option value="percentage">Percentage</option>
                    <option value="scale">Scale 1-10</option>
                    <option value="fibonacci">Fibonacci</option>
                </select>

                <label class="label">Choices</label>
                <div id="choices-container"></div>

                <button type="button" class="add-btn" onclick="addChoice()">+ Add Choice</button>

                <label class="label">Duration</label>
                <select name="duration" class="input">
                    <option value="00:00:15">15s</option>
                    <option value="00:00:30">30s</option>
                    <option value="00:01:00">1min</option>
                    <option value="00:02:00">2min</option>
                </select>

                <button class="primary">Save Topic</button>
            </form>

        </div>

        <!-- RIGHT -->
        <div class="card right">

            <!-- START ROOM -->
            <form method="GET" action="/rooms/{{$data->id}}/start">
                @csrf
                @if($data->status !== 'started')
                    <button class="success">▶ Start Room</button>
                @else
                    <button disabled style="background:gray;width:100%;">Room Started</button>
                @endif
            </form>

            <h3 class="title">Topics</h3>

            @if(isset($topics)) 
                @foreach($topics as $index => $q)
                <a href="/update/topic/{{$q->id}}/room/{{$q->room_id}}" style="text-decoration:none;color:inherit;">
                    <div class="question">
                        <div style="display:flex;gap:10px;">
                            <div class="q-number">{{ $index+1 }}</div>
                            <div>{{ $q->name }}</div>
                        </div>
                        <span class="time">{{ $q->duration }}</span>
                    </div>
                </a>
                @endforeach
            @endif

        </div>

    </div>
</div>

<script>
function createChoice(value = "", placeholder="New Choice"){
    let div = document.createElement("div");
    div.className = "choice-item";

    let input = document.createElement("input");
    input.type = "text";
    input.name = "choices[]";
    input.className = "input";
    input.value = value;
    input.placeholder = placeholder;

    let btn = document.createElement("button");
    btn.type = "button";
    btn.className = "remove-btn";
    btn.innerText = "-";

    btn.onclick = function(){
        div.remove();
    };

    div.appendChild(input);
    div.appendChild(btn);

    document.getElementById("choices-container").appendChild(div);
}

function addChoice(){
    createChoice();
}

function changeMethod(method){
    let c = document.getElementById("choices-container");
    c.innerHTML = "";

    if(method === "custom"){
        createChoice("", "Choice 1");
    }

    if(method === "percentage"){
        createChoice("0","0%");
        createChoice("50","50%");
        createChoice("100","100%");
    }

    if(method === "scale"){
        for(let i=1;i<=10;i++){
            createChoice(i);
        }
    }

    if(method === "fibonacci"){
        let fib=[1,2,3,5,8,13];
        fib.forEach(v=> createChoice(v));
    }
}

window.onload = () => {
    createChoice("", "Choice 1");
};
</script>

</body>
</html>