<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Topic</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI';}

body{
    background:#f5f7fa;
    color:#1a1a2e;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.wrapper{width:1100px;}

.container{display:flex;gap:40px;}

.left,.right{
    background:#fff;
    padding:25px;
    border-radius:15px;
    border:1px solid #e0e0e0;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

.left{width:65%;}
.right{width:35%;}

.label{color:#1a73e8;margin-bottom:6px;display:block;}

.input{
    width:100%;
    background:#f5f7fa;
    border:2px solid #e0e0e0;
    padding:12px;
    border-radius:8px;
    color:#1a1a2e;
    outline:none;
    transition:0.2s;
}

.input:focus{border-color:#1a73e8;background:#fff;}

#choices-container{ max-height:200px; overflow-y:auto; padding-right:5px; margin-bottom:10px; }

.choice-item{ display:flex; gap:10px; align-items:center; margin-bottom:8px; }

.remove-btn{
    background:#e74c3c;
    border:none;
    color:#fff;
    width:28px; height:28px;
    border-radius:50%;
    cursor:pointer;
    font-size:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
}

button{
    background:#1a73e8;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:8px;
    cursor:pointer;
    width:100%;
    margin-top:10px;
    font-weight:bold;
    transition:0.2s;
}

button:hover{background:#1558b0;}

.add-btn{width:auto;padding:8px 12px;background:#e0e0e0;color:#1a1a2e;}
.add-btn:hover{background:#d0d0d0;}

.question{
    display:flex;
    justify-content:space-between;
    background:#f5f7fa;
    padding:10px;
    border-radius:8px;
    margin-bottom:10px;
    border:1px solid #e0e0e0;
    transition:0.2s;
}

.question:hover{background:#f0f4ff;border-color:#1a73e8;}

.q-number{background:#e0e0e0;color:#1a1a2e;padding:5px 10px;border-radius:6px;}

.time{background:#1a73e8;color:#fff;padding:4px 8px;border-radius:6px;}
</style>
</head>

<body>

<span>
@include('components.navbar')
</span>

<div class="wrapper">

@if(session('success'))
<div style="background:rgba(39,174,96,0.1);border:1px solid #27ae60;color:#27ae60;padding:10px;margin-bottom:10px;border-radius:6px;">
    {{ session('success') }}
</div>
@endif

<div class="container">

<!-- LEFT -->
<div class="left">

<form method="POST" action="/update/topic/{{$data->id}}/room/{{$data->room_id}}">
@csrf

<label class="label">Topic</label>
<input type="text" name="topic_name" class="input" value="{{ $data->name }}">

<label class="label">Vote Method</label>
<select name="vote_method" class="input" onchange="if(confirm('Reset choices?')) changeMethod(this.value)">
    <option value="custom" {{ $data->vote_method == 'custom' ? 'selected' : '' }}>Custom</option>
    <option value="percentage" {{ $data->vote_method == 'percentage' ? 'selected' : '' }}>Percentage</option>
    <option value="scale" {{ $data->vote_method == 'scale' ? 'selected' : '' }}>Scale 1-10</option>
    <option value="fibonacci" {{ $data->vote_method == 'fibonacci' ? 'selected' : '' }}>Fibonacci</option>
</select>

<label class="label">Choices</label>
<div id="choices-container"></div>

<button type="button" class="add-btn" onclick="addChoice()">+ Add Choice</button>

<label class="label">Duration</label>
<select name="duration" class="input">
    <option value="00:00:15" {{ $data->duration == '00:00:15' ? 'selected' : '' }}>15s</option>
    <option value="00:00:30" {{ $data->duration == '00:00:30' ? 'selected' : '' }}>30s</option>
    <option value="00:01:00" {{ $data->duration == '00:01:00' ? 'selected' : '' }}>1min</option>
    <option value="00:02:00" {{ $data->duration == '00:02:00' ? 'selected' : '' }}>2min</option>
</select>

<button>Update Topic</button>

</form>

@if($data->status != 'started')
<form method="POST" action="/start/voting/{{$data->id}}">
    @csrf
    <button onclick="return confirm('Start voting now?')" style="background:#27ae60;">Start Voting</button>
</form>
@else
<div style="background:#f5f7fa;border:1px solid #e0e0e0;padding:10px;border-radius:8px;margin-top:10px;text-align:center;color:#888;">
    Voting Already Started
</div>
@endif

</div>

<!-- RIGHT -->
<div class="right">

<h3 style="color:#1a73e8;margin-bottom:10px;">Topics</h3>

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

let existingChoices = @json($choixes);

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
    btn.onclick = function(){ div.remove(); };

    div.appendChild(input);
    div.appendChild(btn);
    document.getElementById("choices-container").appendChild(div);
}

function addChoice(){ createChoice(); }

function changeMethod(method){
    let c = document.getElementById("choices-container");
    c.innerHTML = "";
    if(method === "custom"){ createChoice("", "Choice 1"); }
    if(method === "percentage"){ createChoice("0","0%"); createChoice("50","50%"); createChoice("100","100%"); }
    if(method === "scale"){ for(let i=1;i<=10;i++) createChoice(i); }
    if(method === "fibonacci"){ [1,2,3,5,8,13].forEach(v=> createChoice(v)); }
}

window.onload = () => {
    if(existingChoices.length > 0){
        existingChoices.forEach(c => { createChoice(c.name); });
    }else{
        createChoice("", "Choice 1");
    }
};

</script>

</body>
</html>
