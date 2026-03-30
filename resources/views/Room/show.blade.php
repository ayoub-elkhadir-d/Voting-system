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
            background-color: #00000;
            color: #fff;
          
            min-height: 100vh;
            padding: 20px;

        }

.container {
    display: flex;
    justify-content: space-between;
    padding: 60px;
    gap: 40px;
}

.left {
    width: 60%;
}

.label {
    color: #FCA311;
    margin-bottom: 10px;
    display: block;
}

.input {
    width: 70%;
    background: #1B1B1B;
    border: none;
    border-radius: 8px;
    padding: 15px;
    color: #fff;
    margin-bottom: 20px;
}

/* ===== CHOIX ===== */
.choix {
    display: flex;
    align-items: center;
    gap: 10px;
}

.add-btn {
    background: #FCA311;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
}

/* ===== DURATION ===== */
.duration {
    margin-top: 20px;
}

.duration label {
    margin-right: 15px;
    font-size: 14px;
}

/* ===== BUTTONS ===== */
.save-btn {
    margin-top: 30px;
    background: #FCA311;
    border: none;
    padding: 10px 30px;
    border-radius: 8px;
    cursor: pointer;
}

.start-main {
    margin-top: 80px;
    background: #FCA311;
    border: none;
    padding: 18px 80px;
    border-radius: 10px;
    font-size: 22px;
    cursor: pointer;
}

/* ===== RIGHT SIDE ===== */
.right {
    width: 30%;
    background: #121212;
    padding: 20px;
    border-radius: 12px;
}

.right h3 {
    color: #FCA311;
    margin-bottom: 15px;
}

/* ===== QUESTION ITEM ===== */
.question {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #1B1B1B;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.q-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.q-number {
    background: #333;
    padding: 6px 10px;
    border-radius: 6px;
}

.q-text {
    font-size: 13px;
}

.time {
    background: #FCA311;
    color: #000;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 12px;
}

.menu {
    cursor: pointer;
}

/* ===== START ALL ===== */
.start-all {
    width: 100%;
    margin-top: 20px;
    background: #FCA311;
    border: none;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>

<body>
   <!-- NAVBAR -->
    @include('components.navbar')

    <!-- ALERT -->
    @if (session('success'))
        <div id="successAlert" class="alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="container">

    <!-- LEFT -->
    <div class="left">

        <label class="label">Question name</label>
        <input type="text" class="input" placeholder="Enter Question ...">

        <label class="label">Choix :</label>
        <div class="choix">
            <input type="text" class="input" placeholder="Choix 1">
            <button class="add-btn">Add</button>
        </div>

        <div class="duration">
            <label class="label">Duration :</label><br>

            <label><input type="radio" name="d"> 30 s</label>
            <label><input type="radio" name="d" checked> 1 min</label>
            <label><input type="radio" name="d"> 2 min</label>
            <label><input type="radio" name="d"> Limited</label>
        </div>

        <button class="save-btn">Save</button>

        <br>
        <button class="start-main">Start</button>

    </div>

    <!-- RIGHT -->
    <div class="right">

        <h3>Questions</h3>

      
        <div class="question">
            <div class="q-left">
                <div class="q-number">{{ 1 }}</div>
                <div class="q-text">How difficult are the lessons?</div>
            </div>

            <div style="display:flex; gap:10px; align-items:center;">
                <span class="time">
                    1 min
                </span>
                <span class="menu">⋮</span>
            </div>
        </div>
      

        <button class="start-all">Start All</button>

    </div>

</div>

</body>
</html>