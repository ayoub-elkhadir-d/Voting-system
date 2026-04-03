<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Topics & Voting</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI';}

body{
    background:#1a1a1a;
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.wrapper{width:1100px;}

.container{display:flex;gap:40px;}

.left,.right{
    background:#111;
    padding:25px;
    border-radius:15px;
}

.left{width:65%;}
.right{width:35%;}

.label{color:#FCA311;margin-bottom:6px;display:block;}

.input{
    width:100%;
    background:#1B1B1B;
    border:none;
    padding:12px;
    border-radius:8px;
    color:#fff;
}

/* SCROLL CHOICES */
#choices-container{
    max-height:200px;
    overflow-y:auto;
    padding-right:5px;
    margin-bottom:10px;
}

/* CHOICE ITEM */
.choice-item{
    display:flex;
    gap:10px;
    align-items:center;
    margin-bottom:8px;
}

.remove-btn{
    background:red;
    border:none;
    color:#fff;
    padding:8px 10px;
    border-radius:6px;
    cursor:pointer;
    width:auto;
}

button{
    background:#FCA311;
    border:none;
    padding:12px;
    border-radius:8px;
    cursor:pointer;
    width:100%;
    margin-top:10px;
    font-weight:bold;
}

.add-btn{width:auto;padding:8px 12px;}

.question{
    display:flex;
    justify-content:space-between;
    background:#1B1B1B;
    padding:10px;
    border-radius:8px;
    margin-bottom:10px;
}

.q-number{background:#333;padding:5px 10px;border-radius:6px;}

.time{background:#FCA311;color:#000;padding:4px 8px;border-radius:6px;}
</style>
</head>

<body>

<span>
@include('components.navbar')
</span>

<div class="wrapper">

@if(session('success'))
<div style="background:green;padding:10px;margin-bottom:10px;border-radius:6px;">
    {{ session('success') }}
</div>
@endif

<div class="container">

<!-- LEFT -->
<div class="left">

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

<button>Save Topic</button>

</form>

</div>

<!-- RIGHT -->
<div class="right">

<h3 style="color:#FCA311;margin-bottom:10px;">Topics</h3>

@if(isset($topics))
@foreach($topics as $index => $q)

<a href="/topics/{{$q->id}}" style="text-decoration:none;color:inherit;">
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