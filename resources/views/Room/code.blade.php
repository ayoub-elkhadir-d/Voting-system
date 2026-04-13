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

/* CARD */
.container{
    display:flex;
    justify-content:center;
    margin-top:40px;
    position:relative;
    z-index:2;
}

.card{
    background:rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.08);
    padding:35px;
    border-radius:20px;
    display:flex;
    gap:50px;
    align-items:center;
    box-shadow:0 20px 60px rgba(0,0,0,0.6);
}

/* CODE */
.code{
    display:flex;
    gap:10px;
}

.box{
    width:60px;
    height:80px;
    background:rgba(0,0,0,0.4);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    border-radius:12px;
    font-weight:bold;
    border:1px solid rgba(255,255,255,0.1);
}

/* RIGHT SIDE */
.right{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:15px;
}

/* QR */
.qr img{
    width:150px;
    height:150px;
    border-radius:12px;
    border:2px solid rgba(255,255,255,0.1);
}

.qr p{
    font-size:13px;
    color:#aaa;
    margin-bottom:8px;
}

/* COPY */
.copy-box{
    display:flex;
    gap:10px;
    align-items:center;
    background:rgba(0,0,0,0.25);
    padding:10px 14px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.08);
}

.copy-box input{
    background:transparent;
    border:none;
    color:#fff;
    outline:none;
    width:240px;
    font-size:13px;
}

.copy-box button{
    background:#ff9f0a;
    border:none;
    padding:8px 12px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

/* REG BUTTON */
.regen{
    background:#6c5ce7;
    border:none;
    padding:10px 14px;
    border-radius:10px;
    color:#fff;
    cursor:pointer;
    font-weight:bold;
}

/* START CENTER BUTTON */
.start-container{
    display:flex;
    justify-content:center;
    margin-top:50px;
    position:relative;
    z-index:2;
}

.start-btn{
    background:linear-gradient(135deg,#ff9f0a,#ff6a00);
    border:none;
    padding:18px 80px;
    font-size:22px;
    border-radius:18px;
    cursor:pointer;
    font-weight:bold;
    color:#000;
    box-shadow:0 15px 40px rgba(255,159,10,0.4);
    transition:0.3s;
    min-width:260px;
}

.start-btn:hover{
    transform:scale(1.08);
    box-shadow:0 20px 60px rgba(255,159,10,0.6);
}

/* RESPONSIVE */
@media(max-width:768px){
    .card{
        flex-direction:column;
        gap:25px;
        text-align:center;
    }

    .box{
        width:45px;
        height:65px;
        font-size:24px;
    }

    .copy-box input{
        width:160px;
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

        <!-- CODE -->
        <div class="code" id="codeBox">
            @foreach($code as $c)
            <div class="box">{{$c}}</div>
             @endforeach
          
        </div>

        <!-- RIGHT -->
        <div class="right">

            <div class="qr">
                <p>Scan to join instantly</p>
                <img id="qrImg" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=917934">
            </div>

            <div class="copy-box">
                <input id="roomLink" value="https://voteroom.com/join/917934" readonly>
                <button onclick="copyLink()">Copy</button>
            </div>

            <button class="regen" >Regenerate Code</button>

        </div>

    </div>
</div>

<!-- CENTER START BUTTON -->
<div class="start-container">
    <button class="start-btn">Start Voting</button>
</div>

<script>



</script>

</body>
</html>