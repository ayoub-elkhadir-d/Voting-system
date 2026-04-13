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

.nav .links{
    display:flex;
    gap:25px;
}

.nav a{
    color:#fff;
    text-decoration:none;
    font-size:14px;
    opacity:0.7;
    transition:0.3s;
}

.nav a:hover{
    opacity:1;
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

/* focus effect */
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

<div class="bg-shape shape1"></div>
<div class="bg-shape shape2"></div>

<div class="nav">
    <div class="logo">VoteRoom</div>
    <div class="links">
        <a href="#">Home</a>
        <a href="#">Rooms</a>
        <a href="#">Join</a>
        <a href="#">About</a>
    </div>
</div>

<div class="title">
    <span>Join</span> Room
</div>

<div class="container">
    <div class="card">

        <!-- INPUTS -->
        <div class="code-inputs">
            <input maxlength="1" oninput="handleInput(this,1)" onkeydown="blockInvalid(event)">
            <input maxlength="1" oninput="handleInput(this,2)" onkeydown="blockInvalid(event)">
            <input maxlength="1" oninput="handleInput(this,3)" onkeydown="blockInvalid(event)">
            <input maxlength="1" oninput="handleInput(this,4)" onkeydown="blockInvalid(event)">
            <input maxlength="1" oninput="handleInput(this,5)" onkeydown="blockInvalid(event)">
            <input maxlength="1" oninput="handleInput(this,6)" onkeydown="blockInvalid(event)">
        </div>

        <button class="join-btn" onclick="joinRoom()">Join Room</button>

        <div class="result" id="result"></div>

    </div>
</div>

<script>

function handleInput(el, index){
    // allow only numbers
    el.value = el.value.replace(/[^0-9]/g, '');

    if(el.value.length === 1){
        let next = el.nextElementSibling;
        if(next) next.focus();
    }
}

/* FIX BACKSPACE BEHAVIOR */
document.querySelectorAll(".code-inputs input").forEach((input, index, arr) => {
    input.addEventListener("keydown", function(e){

        // BACKSPACE FIX
        if(e.key === "Backspace"){
            if(this.value === ""){
                let prev = this.previousElementSibling;
                if(prev){
                    prev.focus();
                    prev.value = ""; // clear previous box
                    e.preventDefault();
                }
            }
        }

    });
});
function blockInvalid(e){
    const allowed = [8,9,37,38,39,40,46];

    if(
        allowed.includes(e.keyCode) ||
        (e.key >= '0' && e.key <= '9')
    ){
        return true;
    }

    e.preventDefault();
}

/* JOIN */
function joinRoom(){
    let inputs = document.querySelectorAll(".code-inputs input");
    let code = "";

    inputs.forEach(i => code += i.value);

    if(code.length < 6){
        document.getElementById("result").innerText =
            "❌ Please enter full numeric code";
        return;
    }

    document.getElementById("result").innerText =
        "✅ Joining room: " + code;
}
</script>

</body>
</html>