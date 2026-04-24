<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Topics & Voting</title>

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

.wrapper{ width:1150px; }

.alert{
    background:rgba(39,174,96,0.1);
    border:1px solid #27ae60;
    color:#27ae60;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
    font-weight:bold;
}

.container{ display:flex; gap:30px; }

.card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
    border:1px solid #e0e0e0;
}

.left{width:65%;}
.right{width:35%;}

.label{ color:#1a73e8; margin:12px 0 6px; display:block; font-size:14px; }

.input{
    width:100%;
    background:#f5f7fa;
    border:2px solid #e0e0e0;
    padding:12px;
    border-radius:10px;
    color:#1a1a2e;
    outline:none;
    transition:0.2s;
}

.input:focus{ border-color:#1a73e8; background:#fff; }

button{
    border:none;
    padding:12px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
    transition:0.2s;
}

.primary{ background:#1a73e8; color:#fff; width:100%; }
.primary:hover{ background:#1558b0; }

.success{ background:#27ae60; color:#fff; width:100%; margin-bottom:15px; }
.success:hover{ background:#219a52; }

.add-btn{ background:#e0e0e0; color:#1a1a2e; padding:8px 12px; margin-top:10px; }
.add-btn:hover{ background:#d0d0d0; }

.remove-btn{ background:#e74c3c; color:#fff; padding:8px 10px; }
.remove-btn:hover{ background:#c0392b; }

#choices-container{ max-height:200px; overflow-y:auto; margin-top:5px; }

.choice-item{ display:flex; gap:10px; margin-bottom:8px; }

.question{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#f5f7fa;
    padding:12px;
    border-radius:10px;
    margin-bottom:10px;
    transition:0.2s;
    border:1px solid #e0e0e0;
}

.question:hover{ background:#f0f4ff; transform:scale(1.02); border-color:#1a73e8; }

.q-number{ background:#e0e0e0; color:#1a1a2e; padding:5px 10px; border-radius:6px; }

.time{ background:#1a73e8; color:#fff; padding:4px 8px; border-radius:6px; }

.title{ margin-bottom:10px; color:#1a73e8; }

/* ── Vote Method Cards ── */
.method-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-top: 6px;
}
.method-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 12px 8px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.18s;
    background: #f5f7fa;
    text-align: center;
    user-select: none;
}
.method-card:hover {
    border-color: #1a73e8;
    background: #eef4ff;
}
.method-card.active {
    border-color: #1a73e8;
    background: #e8f0fe;
    box-shadow: 0 2px 10px rgba(26,115,232,0.15);
}
.method-card .icon { font-size: 22px; }
.method-card .name { font-size: 12px; font-weight: 700; color: #1a1a2e; }
.method-card .desc { font-size: 10px; color: #888; }

</style>

</head>

<body>

@include('components.navbar')

<div class="wrapper">

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="container">

        <!-- LEFT -->
        <div class="card left">
            <h3 class="title">Create Topic</h3>

            <form method="POST" action="/rooms/{{$data->id}}/topic">
                @csrf

                <label class="label">Topic</label>
                <input type="text" name="topic_name" class="input" placeholder="Enter topic">

                <!-- ── Choices section ── -->
                <div style="border:2px solid #e0e0e0;border-radius:14px;padding:18px;margin-top:14px;">

                    <!-- Vote type toggle -->
                    <div style="display:flex;gap:10px;margin-bottom:14px;">
                        <input type="hidden" name="vote_method" id="vote_method_input" value="select_one">
                        <div id="btn_single" onclick="setVoteType('select_one')" style="flex:1;padding:10px;border:2px solid #1a73e8;border-radius:10px;text-align:center;cursor:pointer;background:#e8f0fe;font-weight:700;font-size:13px;transition:0.2s;">
                             Single Choice
                        </div>
                        <div id="btn_multi" onclick="setVoteType('select_multiple')" style="flex:1;padding:10px;border:2px solid #e0e0e0;border-radius:10px;text-align:center;cursor:pointer;background:#f5f7fa;font-weight:700;font-size:13px;transition:0.2s;">
                         Multiple Choice
                        </div>
                    </div>

                    <!-- Max choices (only shown for multiple) -->
                    <div id="max_choices_row" style="display:none;margin-bottom:14px;">
                        <label class="label" style="margin-top:0;">Max choices allowed</label>
                        <input type="number" name="max_choices" id="max_choices_input" class="input" value="2" min="2" max="20" style="width:120px;">
                    </div>

                    <!-- Choice type cards -->
                    <label class="label" style="margin-top:0;">Choice Type</label>
                    <input type="hidden" name="choice_type" id="choice_type_input" value="custom">
                    <div class="method-grid" style="margin-bottom:12px;">
                        <div class="method-card active" onclick="selectChoiceType('custom', this)"><span class="icon"></span><span class="name">Custom</span><span class="desc">Your own choices</span></div>
                        <div class="method-card" onclick="selectChoiceType('percentage', this)"><span class="icon"></span><span class="name">Percentage</span><span class="desc">0% – 50% – 100%</span></div>
                        <div class="method-card" onclick="selectChoiceType('scale', this)"><span class="icon"></span><span class="name">Scale 1-10</span><span class="desc">Numeric rating</span></div>
                        <div class="method-card" onclick="selectChoiceType('fibonacci', this)"><span class="icon"></span><span class="name">Fibonacci</span><span class="desc">1,2,3,5,8,13</span></div>
                        <div class="method-card" onclick="selectChoiceType('countries', this)"><span class="icon"></span><span class="name">Countries</span><span class="desc">Pick from list</span></div>
                    </div>

                    <label class="label" style="margin-top:0;">Choices</label>
                    <div id="choices-container"></div>

                    <div style="display:flex;gap:8px;margin-top:10px;align-items:center;">
                        <button type="button" class="add-btn" onclick="addChoice()">+ Add Choice</button>
                        <label class="add-btn">
                            Import File
                            <input type="file" accept=".txt,.csv" style="display:none;" onchange="importChoices(this)">
                        </label>
                    </div>

                </div>

                <label class="label">Duration</label>
                <select name="duration" class="input">
                    <option value="00:00:15">15s</option>
                    <option value="00:00:30">30s</option>
                    <option value="00:01:00">1min</option>
                    <option value="00:02:00">2min</option>
                </select>

                <button class="primary">Save Topic</button>
            </form>
        </div>

        <!-- RIGHT -->
        <div class="card right">
            <form method="GET" action="/rooms/{{$data->id}}/start">
                @csrf
                @if($data->status !== 'started')
                    <button class="success">▶ Start Room</button>
                @else
                    <button disabled style="background:#ccc;color:#888;width:100%;">Room Started</button>
                @endif
            </form>

            <h3 class="title">Topics</h3>

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

function setVoteType(type) {
    document.getElementById('vote_method_input').value = type;
    var isSingle = type === 'select_one';
    document.getElementById('btn_single').style.borderColor  = isSingle ? '#1a73e8' : '#e0e0e0';
    document.getElementById('btn_single').style.background   = isSingle ? '#e8f0fe' : '#f5f7fa';
    document.getElementById('btn_multi').style.borderColor   = isSingle ? '#e0e0e0' : '#1a73e8';
    document.getElementById('btn_multi').style.background    = isSingle ? '#f5f7fa' : '#e8f0fe';
    document.getElementById('max_choices_row').style.display = isSingle ? 'none' : 'block';
}

function selectChoiceType(type, card) {
    document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    document.getElementById('choice_type_input').value = type;
    changeMethod(type);
}

function selectMethod(method, card) {
    selectChoiceType(method, card);
}

function changeMethod(method){
    let c = document.getElementById("choices-container");
    c.innerHTML = "";
    if(method === "custom"){ createChoice("", "Choice 1"); }
    if(method === "percentage"){ createChoice("0","0%"); createChoice("50","50%"); createChoice("100","100%"); }
    if(method === "scale"){ for(let i=1;i<=10;i++) createChoice(i); }
    if(method === "fibonacci"){ [1,2,3,5,8,13].forEach(v=> createChoice(v)); }
    if(method === "countries"){ openCountryPicker(); }
}

function importChoices(input) {
    let file = input.files[0];
    if (!file) return;

    let reader = new FileReader();
    reader.onload = function (e) {
        
        let lines = e.target.result.split(/\r?\n/).map(l => l.trim()).filter(l => l !== '');

 
        lines.forEach(line => createChoice(line));
    };
    reader.readAsText(file);

   
    input.value = '';
}

window.onload = () => { createChoice("", "Choice 1"); };
</script>

<!-- Country Picker Modal -->
<div id="picker-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;width:420px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <div style="padding:16px 20px;border-bottom:1px solid #eee;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:700;font-size:15px;">Select Countries</span>
            <button onclick="closePicker()" style="background:none;border:none;font-size:20px;cursor:pointer;color:#888;">&times;</button>
        </div>
        <div style="padding:12px 20px;border-bottom:1px solid #eee;">
            <input id="picker-search" type="text" placeholder="Search country..." oninput="filterPicker(this.value)"
                style="width:100%;padding:8px 12px;border:1px solid #ddd;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div id="picker-list" style="overflow-y:auto;flex:1;padding:8px 0;"></div>
        <div style="padding:12px 20px;border-top:1px solid #eee;text-align:right;">
            <button onclick="closePicker()" style="background:#1a73e8;color:#fff;border:none;padding:8px 20px;border-radius:8px;font-weight:700;cursor:pointer;">Done</button>
        </div>
    </div>
</div>

<script>
const COUNTRIES = @json(json_decode(file_get_contents(database_path('countries.json')), true));

function openCountryPicker() {
    document.getElementById('picker-search').value = '';
    document.getElementById('picker-modal').style.display = 'flex';
    renderPicker(COUNTRIES);
}

function closePicker() {
    document.getElementById('picker-modal').style.display = 'none';
}

function filterPicker(q) {
    renderPicker(COUNTRIES.filter(c => c.name.toLowerCase().includes(q.toLowerCase())));
}

function renderPicker(items) {
    const list = document.getElementById('picker-list');
    list.innerHTML = items.map(c => {
        const exists = [...document.querySelectorAll('#choices-container input')].some(i => i.value === c.name);
        return `<div onclick="toggleCountry('${c.name.replace(/'/g, "\\'")}')"
            style="padding:10px 20px;cursor:pointer;display:flex;align-items:center;gap:12px;font-size:13px;background:${exists ? '#e8f0fe' : '#fff'};transition:0.15s;"
            onmouseover="this.style.background='#f5f9ff'" onmouseout="this.style.background='${exists ? '#e8f0fe' : '#fff'}'">
            <img src="https://flagcdn.com/24x18/${c.code}.png" width="24" height="18" style="border-radius:3px;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
            <span style="flex:1;">${c.name}</span>
            <span style="font-size:16px;">${exists ? '✅' : ''}</span>
        </div>`;
    }).join('');
}

function toggleCountry(name) {
    const existing = [...document.querySelectorAll('#choices-container input')].find(i => i.value === name);
    if (existing) {
        existing.closest('.choice-item').remove();
    } else {
        createChoice(name);
    }
    filterPicker(document.getElementById('picker-search').value);
}
</script>

</body>
</html>
