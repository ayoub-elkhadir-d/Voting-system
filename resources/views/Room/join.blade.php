<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Room</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

body {
    background: #222831;
    color: #DDDDDD;
    overflow-x: hidden;
}

.bg-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.2;
    z-index: 0;
}

.shape1 {
    width: 300px;
    height: 300px;
    background: #F05454;
    top: -80px;
    left: -80px;
}

.shape2 {
    width: 250px;
    height: 250px;
    background: #30475E;
    bottom: -80px;
    right: -80px;
}

.title {
    text-align: center;
    margin-top: 50px;
    font-size: 32px;
    font-weight: bold;
    position: relative;
    z-index: 2;
}

.title span {
    color: #F05454;
}

.container {
    display: flex;
    justify-content: center;
    margin-top: 60px;
    position: relative;
    z-index: 2;
}

.card {
    background: #1a1e23;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(221, 221, 221, 0.1);
    padding: 40px;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 25px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}

.code-inputs {
    display: flex;
    gap: 12px;
}

.code-inputs input {
    width: 60px;
    height: 80px;
    text-align: center;
    font-size: 30px;
    border-radius: 12px;
    border: 1px solid rgba(221, 221, 221, 0.1);
    background: #222831;
    color: #F05454;
    font-weight: bold;
    outline: none;
    transition: 0.3s;
}

.code-inputs input:focus {
    border-color: #1a1e23;
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(240, 84, 84, 0.2);
}

.join-btn {
    background: #F05454;
    border: none;
    padding: 16px 60px;
    font-size: 20px;
    border-radius: 16px;
    cursor: pointer;
    font-weight: bold;
    color: white;
    box-shadow: 0 10px 30px rgba(240, 84, 84, 0.3);
    transition: 0.3s;
}

.join-btn:hover {
    transform: scale(1.05);
    background: #d44646;
}

.result {
    font-size: 14px;
    color: #888;
}

.alert-success {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #27ae60;
    color: white;
    padding: 12px 16px;
    border-radius: 10px;
    z-index: 99999;
}

@media(max-width:768px){
    .code-inputs input{
        width: 45px;
        height: 65px;
        font-size: 24px;
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
        @if(session('error'))
        <div style="background:#F05454;color:#fff;padding:12px 20px;border-radius:10px;text-align:center;font-weight:bold;">
            {{ session('error') }}
        </div>
        @endif

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

inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
        input.value = input.value.replace(/[^0-9]/g, '');
        if(input.value && inputs[index + 1]){
            inputs[index + 1].focus();
        }
    });

    input.addEventListener("keydown", (e) => {
        if(e.key === "Backspace" && input.value === "" && inputs[index - 1]){
            inputs[index - 1].focus();
        }
    });

    input.addEventListener("paste", (e) => {
        e.preventDefault();
        let pasteData = e.clipboardData.getData("text").replace(/[^0-9]/g, '');
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