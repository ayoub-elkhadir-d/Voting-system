<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Room</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, sans-serif;
}

body{
    background:#0b0b0f;
    color:#fff;
    overflow-x:hidden;
}

/* BACKGROUND */
.bg-shape{
    position:absolute;
    border-radius:50%;
    filter: blur(80px);
    opacity:0.4;
    z-index:0;
}

.shape1{
    width:300px;
    height:300px;
    background:#ff9f0a;
    top:-80px;
    left:-80px;
}

.shape2{
    width:250px;
    height:250px;
    background:#6c5ce7;
    bottom:-80px;
    right:-80px;
}

/* NAV */
.nav{
    height:65px;
    background:rgba(20,20,25,0.7);
    backdrop-filter: blur(10px);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
    border-bottom:1px solid rgba(255,255,255,0.05);
    position:relative;
    z-index:2;
}

.nav .logo{
    font-weight:bold;
    font-size:18px;
    color:#ff9f0a;
}

/* TITLE */
.title{
    text-align:center;
    margin-top:50px;
    font-size:32px;
    font-weight:bold;
    position:relative;
    z-index:2;
}

.title span{
    color:#ff9f0a;
}

/* CONTAINER */
.container{
    display:flex;
    justify-content:center;
    margin-top:60px;
    position:relative;
    z-index:2;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.08);
    padding:40px;
    border-radius:20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:25px;
    box-shadow:0 20px 60px rgba(0,0,0,0.6);
}

/* INPUTS */
.code-inputs{
    display:flex;
    gap:12px;
}

.code-inputs input{
    width:60px;
    height:80px;
    text-align:center;
    font-size:30px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.15);
    background:rgba(0,0,0,0.4);
    color:#fff;
    outline:none;
    transition:0.3s;
}

.code-inputs input:focus{
    border-color:#ff9f0a;
    transform:scale(1.05);
}

/* BUTTON */
.join-btn{
    background:linear-gradient(135deg,#ff9f0a,#ff6a00);
    border:none;
    padding:16px 60px;
    font-size:20px;
    border-radius:16px;
    cursor:pointer;
    font-weight:bold;
    color:#000;
    box-shadow:0 15px 40px rgba(255,159,10,0.4);
    transition:0.3s;
}

.join-btn:hover{
    transform:scale(1.07);
}

/* RESULT */
.result{
    font-size:14px;
    color:#aaa;
}
.alert-success{
    position:fixed;
    top:20px;
    right:20px;
    background:#00e676;
    color:#000;
    padding:12px 16px;
    border-radius:10px;
    z-index:99999;
}
/* RESPONSIVE */
@media(max-width:768px){
    .code-inputs input{
        width:45px;
        height:65px;
        font-size:24px;
    }
}
</style>
</head>

<body>
@include('components.navbar')

@if (session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<div class="bg-shape shape1"></div>
<div class="bg-shape shape2"></div>

<div class="title">
    <span>Join</span> Room
</div>

<div class="container">
    <form method="POST" action="/rooms/join">
       @csrf

    <div class="card">

        <!-- ERROR -->
        @if(session('error'))
        <div style="background:#d32f2f;color:#fff;padding:12px 20px;border-radius:10px;text-align:center;font-weight:bold;">
            {{ session('error') }}
        </div>
        @endif

        <!-- INPUTS -->
        <div class="code-inputs">
            <input name="d1" maxlength="1">
            <input name="d2" maxlength="1">
            <input name="d3" maxlength="1">
            <input name="d4" maxlength="1">
            <input name="d5" maxlength="1">
            <input name="d6" maxlength="1">
        </div>

        <button class="join-btn">Join Room</button>

    </div>
</form>

<div class="result" id="result"></div>

</div>

<script>

const inputs = document.querySelectorAll(".code-inputs input");

/* INPUT HANDLING */
inputs.forEach((input, index) => {

    input.addEventListener("input", () => {
        input.value = input.value.replace(/[^0-9]/g, '');

        if(input.value && inputs[index + 1]){
            inputs[index + 1].focus();
        }

        checkAutoSubmit();
    });

    input.addEventListener("keydown", (e) => {
        if(e.key === "Backspace" && input.value === "" && inputs[index - 1]){
            inputs[index - 1].focus();
        }
    });

    input.addEventListener("paste", (e) => {
        e.preventDefault();

        let pasteData = e.clipboardData.getData("text")
            .replace(/[^0-9]/g, '');

        pasteData.split("").forEach((char, i) => {
            if(inputs[index + i]){
                inputs[index + i].value = char;
            }
        });

        let last = index + pasteData.length - 1;
        if(inputs[last]) inputs[last].focus();

        
    });

});



</script>

</body>
</html>