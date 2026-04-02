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
    margin-bottom:10px;
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
<div id="choices-container">
    <input type="text" name="choices[]" class="input" placeholder="Choice 1">
</div>

<button type="button" class="add-btn" onclick="addChoice()">+ Add Choice</button>

<label class="label">Duration</label>
<select name="duration" class="input">
    <option value="15">15s</option>
    <option value="30">30s</option>
    <option value="60">1min</option>
    <option value="120">2min</option>
</select>

<button>Save Topic</button>

</form>

</div>

<!-- RIGHT -->
<div class="right">

<h3 style="color:#FCA311;margin-bottom:10px;">Topics</h3>

@if(isset($topics))
@foreach($topics as $index => $q)
<div class="question">
    <div style="display:flex;gap:10px;">
        <div class="q-number">{{ $index+1 }}</div>
        <div>{{ $q->name }}</div>
    </div>
    <span class="time">{{ $q->duration }}s</span>
</div>
@endforeach
@endif

</div>

</div>
</div>

<script>

function addChoice(){
    let input=document.createElement("input");
    input.type="text";
    input.name="choices[]";
    input.className="input";
    input.placeholder="New Choice";
    document.getElementById("choices-container").appendChild(input);
}

function changeMethod(method){
    let c=document.getElementById("choices-container");
    c.innerHTML="";

    if(method==="custom"){
        c.innerHTML ="";
        c.innerHTML=`<input type="text" name="choices[]" class="input" placeholder="Choice 1">`;
    }

    if(method==="percentage"){
        c.innerHTML ="";
        c.innerHTML=`
        <input type="number" name="choices[]" class="input" placeholder="0%">
        <input type="number" name="choices[]" class="input" placeholder="50%">
        <input type="number" name="choices[]" class="input" placeholder="100%">
        `;
    }

    if(method==="scale"){
        c.innerHTML ="";
        for(let i=1;i<=10;i++){
            c.innerHTML+=`<input type="text" name="choices[]" value="${i}" class="input">`;
        }
    }

    if(method==="fibonacci"){
        c.innerHTML ="";
        let fib=[1,2,3,5,8,13];
        fib.forEach(v=>{
            c.innerHTML+=`<input type="text" name="choices[]" value="${v}" class="input">`;
        });
    }
}

</script>

</body>
</html>