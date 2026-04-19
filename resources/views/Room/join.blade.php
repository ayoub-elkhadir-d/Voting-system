<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Room</title>
<style>
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
body{ background:#dfdfdf; color:#1a1a2e; min-height:100vh; overflow-x:hidden; }
.title{ text-align:center; margin-top:60px; font-size:34px; font-weight:800; position:relative; z-index:2; color:#1a1a2e; }
.title span{ color:#1a73e8; }
.container{ display:flex; justify-content:center; margin-top:50px; position:relative; z-index:2; padding-bottom:60px; }

.card{
    background:#fff;
    border:1px solid #e0e0e0;
    padding:44px 40px;
    border-radius:20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:28px;
    box-shadow:0 8px 32px rgba(0,0,0,0.08);
    min-width:420px;
}
.code-inputs{ display:flex; gap:12px; }
.code-inputs input{
    width:62px; height:82px;
    text-align:center;
    font-size:32px;
    font-weight:800;
    border-radius:12px;
    border:2px solid #e0e0e0;
    background:#dfdfdf;
    color:#1a73e8;
    outline:none;
    transition:0.25s;
}
.code-inputs input:focus{
    border-color:#1a73e8;
    transform:scale(1.06);
    box-shadow:0 0 16px rgba(26,115,232,0.2);
    background:#fff;
}
.join-btn{
    background:#1a73e8;
    border:none;
    padding:15px 60px;
    font-size:18px;
    border-radius:14px;
    cursor:pointer;
    font-weight:800;
    color:#fff;
    box-shadow:0 6px 20px rgba(26,115,232,0.25);
    transition:0.25s;
    width:100%;
}
.join-btn:hover{ background:#1558b0; transform:translateY(-2px); box-shadow:0 10px 28px rgba(26,115,232,0.35); }
.error-alert{
    background:rgba(231,76,60,0.08);
    border:1px solid #e74c3c;
    color:#e74c3c;
    padding:12px 20px;
    border-radius:10px;
    text-align:center;
    font-weight:600;
    font-size:14px;
    width:100%;
}
.alert-success{
    position:fixed; top:20px; right:20px;
    background:#fff;
    border-left:4px solid #1a73e8;
    color:#1a1a2e;
    padding:14px 20px;
    border-radius:10px;
    z-index:99999;
    font-weight:600;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}
@media(max-width:520px){
    .card{ min-width:unset; padding:30px 20px; }
    .code-inputs input{ width:46px; height:66px; font-size:24px; }
}
</style>
</head>
<body>
@include('components.navbar')

@if (session('success'))
<div class="alert-success">✔ {{ session('success') }}</div>
@endif

<div class="title"><span>Join</span> Room</div>

<div class="container">
    <form method="POST" action="/rooms/join">
        @csrf
        <div class="card">
            @if(session('error'))
            <div class="error-alert">{{ session('error') }}</div>
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
</div>

<script>
const inputs = document.querySelectorAll(".code-inputs input");
inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
        input.value = input.value.replace(/[^0-9]/g, '');
        if(input.value && inputs[index + 1]) inputs[index + 1].focus();
    });
    input.addEventListener("keydown", (e) => {
        if(e.key === "Backspace" && input.value === "" && inputs[index - 1]) inputs[index - 1].focus();
    });
    input.addEventListener("paste", (e) => {
        e.preventDefault();
        let pasteData = e.clipboardData.getData("text").replace(/[^0-9]/g, '');
        pasteData.split("").forEach((char, i) => { if(inputs[index + i]) inputs[index + i].value = char; });
        let last = index + pasteData.length - 1;
        if(inputs[last]) inputs[last].focus();
    });
});
</script>
</body>
</html>
