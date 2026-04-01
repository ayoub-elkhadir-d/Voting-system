<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Questions UI</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #000;
    color: #fff;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.wrapper {
    width: 1100px;
}

.container {
    display: flex;
    gap: 40px;
}

/* LEFT */
.left {
    width: 65%;
    background: #111;
    padding: 30px;
    border-radius: 15px;
}

.label {
    color: #FCA311;
    margin-bottom: 8px;
    display: block;
}

.input {
    width: 100%;
    background: #1B1B1B;
    border: none;
    border-radius: 8px;
    padding: 14px;
    color: #fff;
    margin-bottom: 15px;
}

.choix {
    display: flex;
    gap: 10px;
}

.add-btn {
    background: #FCA311;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
}

/* duration */
.duration {
    margin-top: 20px;
}

.duration label {
    margin-right: 15px;
    cursor: pointer;
}

/* buttons */
.save-btn, .start-main {
    background: #FCA311;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    margin-top: 15px;
    font-weight: bold;
}

.start-main {
    font-size: 18px;
}

/* RIGHT */
.right {
    width: 35%;
    background: #111;
    padding: 20px;
    border-radius: 15px;
}

.right h3 {
    color: #FCA311;
    margin-bottom: 15px;
}

.question {
    display: flex;
    justify-content: space-between;
    background: #1B1B1B;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 10px;
}

.q-left {
    display: flex;
    gap: 10px;
}

.q-number {
    background: #333;
    padding: 5px 10px;
    border-radius: 6px;
}

.time {
    background: #FCA311;
    color: #000;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
}

.start-all {
    width: 100%;
    margin-top: 15px;
    background: #FCA311;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- ALERT -->
    @if (session('success'))
        <div style="background:green;padding:10px;margin-bottom:10px;border-radius:6px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">

        <!-- LEFT -->
        <div class="left">

            <form method="POST" action="/rooms/{{$data->id}}/topic">
                @csrf

                <!-- QUESTION -->
                <label class="label">Topic</label>
                <input type="text" name="question" class="input" placeholder="Enter question">

                <!-- CHOIX -->
                <label class="label">Choices</label>

                <div id="choices">
                    <input type="text" name="choices[]" class="input" placeholder="Choice 1">
                </div>

                <button type="button" class="add-btn" onclick="addChoice()">+ Add Choice</button>

                <!-- DURATION -->
                <div class="duration">
                    <label class="label">Duration</label><br>

                    <label><input type="radio" name="duration" value="15"> 15s</label>
                    <label><input type="radio" name="duration" value="30"> 30s</label>
                    <label><input type="radio" name="duration" value="60"> 1min</label>
                    <label><input type="radio" name="duration" value="120"> 2min</label>
                </div>

                <button class="save-btn">Save Topic</button>

            </form>

            <button class="start-main">Start Quiz</button>

        </div>

        <!-- RIGHT -->
        <div class="right">

            <h3>Questions</h3>



            <button class="start-all">Start All</button>

        </div>

    </div>

</div>

<script>
function addChoice() {
    let div = document.createElement("input");
    div.type = "text";
    div.name = "choices[]";
    div.placeholder = "New Choice";
    div.className = "input";

    document.getElementById("choices").appendChild(div);
}
</script>

</body>
</html>