<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Topics</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI';}
body{ background:#f5f7fa; color:#1a1a2e; display:flex; justify-content:center; align-items:center; min-height:100vh; }
.wrapper{ width:1150px; }
.alert{ background:rgba(39,174,96,0.1); border:1px solid #27ae60; color:#27ae60; padding:12px; border-radius:8px; margin-bottom:15px; text-align:center; font-weight:bold; }
.container{ display:flex; gap:30px; }
.card{ background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border:1px solid #e0e0e0; }
.left{width:65%;} .right{width:35%;}
.label{ color:#1a73e8; margin:12px 0 6px; display:block; font-size:13px; font-weight:600; }
.input{ width:100%; background:#f5f7fa; border:2px solid #e0e0e0; padding:12px; border-radius:10px; color:#1a1a2e; outline:none; transition:0.2s; font-size:14px; }
.input:focus{ border-color:#1a73e8; background:#fff; }
button{ border:none; padding:12px; border-radius:10px; cursor:pointer; font-weight:bold; transition:0.2s; }
.primary{ background:#1a73e8; color:#fff; width:100%; margin-top:10px; }
.primary:hover{ background:#1558b0; }
.danger{ background:#e74c3c; color:#fff; width:100%; margin-top:8px; }
.danger:hover{ background:#c0392b; }
.success-btn{ background:#27ae60; color:#fff; width:100%; margin-bottom:15px; }
.success-btn:hover{ background:#219a52; }
.add-btn{ background:#e0e0e0; color:#1a1a2e; padding:8px 12px; margin-top:10px; }
.add-btn:hover{ background:#d0d0d0; }
.remove-btn{ background:#e74c3c; color:#fff; padding:8px 10px; flex-shrink:0; }
#choices-container{ max-height:200px; overflow-y:auto; margin-top:5px; }
.choice-item{ display:flex; gap:10px; margin-bottom:8px; }
.question{ display:flex; justify-content:space-between; align-items:center; background:#f5f7fa; padding:10px 12px; border-radius:10px; margin-bottom:6px; border:2px solid #e0e0e0; transition:0.2s; }
.question.active-edit{ border-color:#1a73e8; background:#f0f4ff; }
.question:hover{ background:#f0f4ff; border-color:#1a73e8; }
.q-left{ display:flex; gap:10px; align-items:center; flex:1; min-width:0; }
.q-number{ background:#e0e0e0; color:#1a1a2e; padding:4px 10px; border-radius:6px; font-size:13px; font-weight:700; flex-shrink:0; }
.q-name{ font-size:13px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.q-right{ display:flex; align-items:center; gap:6px; flex-shrink:0; }
.time{ background:#1a73e8; color:#fff; padding:4px 8px; border-radius:6px; font-size:12px; }
.q-edit-btn{ background:#e8f0fe; color:#1a73e8; border:none; padding:5px 10px; border-radius:6px; cursor:pointer; font-size:12px; font-weight:700; }
.q-del-btn{ background:#fde8e8; color:#e74c3c; border:none; padding:5px 10px; border-radius:6px; cursor:pointer; font-size:12px; font-weight:700; }
.form-title{ font-size:16px; font-weight:800; color:#1a1a2e; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
.cancel-btn{ background:#f0f0f0; color:#666; width:100%; margin-top:8px; }
.cancel-btn:hover{ background:#e0e0e0; }
.method-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-top:6px; }
.method-card{ display:flex; flex-direction:column; align-items:center; gap:3px; padding:10px 6px; border:2px solid #e0e0e0; border-radius:10px; cursor:pointer; transition:all 0.18s; background:#f5f7fa; text-align:center; user-select:none; }
.method-card:hover{ border-color:#1a73e8; background:#eef4ff; }
.method-card.active{ border-color:#1a73e8; background:#e8f0fe; }
.method-card .name{ font-size:11px; font-weight:700; color:#1a1a2e; }
.method-card .desc{ font-size:10px; color:#888; }
</style>
</head>
<body>
@include('components.navbar')

@php $editing = isset($editTopic); @endphp

<div class="wrapper">

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="background:rgba(231,76,60,0.1);border:1px solid #e74c3c;color:#e74c3c;padding:12px;border-radius:8px;margin-bottom:15px;font-weight:600;">
            @foreach($errors->all() as $error)
                <div>⚠ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="container">

        <!-- LEFT: Create / Edit Form -->
        <div class="card left">
            <p class="form-title">
                @if($editing) ✏ Edit Topic @else  New Topic @endif
            </p>

            <form method="POST"
                  action="{{ $editing
                      ? '/rooms/'.$data->id.'/topics/'.$editTopic->id
                      : '/rooms/'.$data->id.'/topic' }}"
                  id="topicForm">
                @csrf

                <label class="label">Topic Name</label>
                <input type="text" name="topic_name" class="input"
                       placeholder="Enter topic name"
                       value="{{ $editing ? $editTopic->name : '' }}" required>

                <!-- Vote type -->
                @php
                    $vm      = $editing ? $editTopic->vote_methode : 'select_one';
                    $isMulti = $vm === 'select_multiple';
                @endphp
                <label class="label">Vote Type</label>
                <input type="hidden" name="vote_method" id="vote_method_input" value="{{ $vm }}">
                <div style="display:flex;gap:10px;margin-bottom:10px;">
                    <div id="btn_single" onclick="setVoteType('select_one')"
                         style="flex:1;padding:10px;border:2px solid {{ !$isMulti ? '#1a73e8' : '#e0e0e0' }};border-radius:10px;text-align:center;cursor:pointer;background:{{ !$isMulti ? '#e8f0fe' : '#f5f7fa' }};font-weight:700;font-size:13px;transition:0.2s;">
                        Single Choice
                    </div>
                    <div id="btn_multi" onclick="setVoteType('select_multiple')"
                         style="flex:1;padding:10px;border:2px solid {{ $isMulti ? '#1a73e8' : '#e0e0e0' }};border-radius:10px;text-align:center;cursor:pointer;background:{{ $isMulti ? '#e8f0fe' : '#f5f7fa' }};font-weight:700;font-size:13px;transition:0.2s;">
                        Multiple Choice
                    </div>
                </div>

                <div id="max_choices_row" style="display:{{ $isMulti ? 'block' : 'none' }};margin-bottom:10px;">
                    <label class="label" style="margin-top:0;">Max choices allowed</label>
                    <input type="number" name="max_choices" id="max_choices_input" class="input"
                           value="{{ $editing ? $editTopic->max_choices : 2 }}" min="2" max="20" style="width:120px;">
                </div>

                <!-- Choices -->
                <div style="border:2px solid #e0e0e0;border-radius:14px;padding:16px;margin-top:10px;">
                    <label class="label" style="margin-top:0;">Choice Type</label>
                    <input type="hidden" name="choice_type" id="choice_type_input" value="custom">
                    <div class="method-grid" style="margin-bottom:12px;">
                        <div class="method-card active" onclick="selectChoiceType('custom',this)"><span class="name">Custom</span><span class="desc">Your own</span></div>
                        <div class="method-card" onclick="selectChoiceType('percentage',this)"><span class="name">Percentage</span><span class="desc">0–50–100%</span></div>
                        <div class="method-card" onclick="selectChoiceType('scale',this)"><span class="name">Scale 1-10</span><span class="desc">Numeric</span></div>
                        <div class="method-card" onclick="selectChoiceType('fibonacci',this)"><span class="name">Fibonacci</span><span class="desc">1,2,3,5,8…</span></div>
                        <div class="method-card" onclick="selectChoiceType('countries',this)"><span class="name">Countries</span><span class="desc">Pick from list</span></div>
                    </div>

                    <label class="label" style="margin-top:0;">Choices</label>
                    <div id="choices-container"></div>
                    <div style="display:flex;gap:8px;margin-top:10px;">
                        <button type="button" class="add-btn" onclick="addChoice()">+ Add Choice</button>
                        <label class="add-btn" style="cursor:pointer;">
                            Import File
                            <input type="file" accept=".txt,.csv" style="display:none;" onchange="importChoices(this)">
                        </label>
                    </div>
                </div>

                <label class="label">Duration</label>
                <select name="duration" class="input">
                    @foreach(['00:00:15'=>'15s','00:00:30'=>'30s','00:01:00'=>'1 min','00:02:00'=>'2 min','00:03:00'=>'3 min','00:05:00'=>'5 min'] as $val=>$label)
                    <option value="{{ $val }}" {{ ($editing && $editTopic->duration==$val) ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <button type="submit" class="primary" form="topicForm">
                    {{ $editing ? 'Save Changes' : 'Save Topic' }}
                </button>

            </form>

            @if($editing)
            <a href="/show/{{ $data->id }}" style="display:block;margin-top:8px;text-decoration:none;">
                <button type="button" class="cancel-btn" style="width:100%;">✕ Cancel</button>
            </a>
            @endif
        </div>

        <!-- RIGHT: Topics List + Start Room -->
        <div class="card right">
            <form method="GET" action="/rooms/{{$data->id}}/start">
                @if($data->status !== 'started')
                    <button type="submit" class="success-btn">▶ Start Room</button>
                @else
                    <button type="button" disabled style="background:#ccc;color:#888;width:100%;border-radius:10px;padding:12px;font-weight:bold;">Room Started</button>
                @endif
            </form>

            <p style="font-size:15px;font-weight:800;color:#1a1a2e;margin-bottom:12px;">Topics</p>

            <div style="max-height:460px;overflow-y:auto;padding-right:4px;">
            @forelse($topics as $index => $q)
            <div class="question {{ ($editing && $editTopic->id == $q->id) ? 'active-edit' : '' }}">
                <div class="q-left">
                    <span class="q-number">{{ $index+1 }}</span>
                    <span class="q-name">{{ $q->name }}</span>
                </div>
                <div class="q-right">
                    <span class="time">{{ $q->duration }}</span>
                    <a href="/rooms/{{$data->id}}/topics/{{$q->id}}/edit">
                        <button type="button" class="q-edit-btn">Edit</button>
                    </a>
                    <form method="POST" action="/rooms/{{$data->id}}/topics/{{$q->id}}"
                          onsubmit="return confirm('Delete?')" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="q-del-btn">Del</button>
                    </form>
                </div>
            </div>
            @empty
            <p style="color:#aaa;font-size:13px;text-align:center;padding:20px 0;">No topics yet</p>
            @endforelse
            </div>
        </div>

    </div>
</div>

<script>
const IS_EDITING  = {{ $editing ? 'true' : 'false' }};
const EDIT_CHOICES = {!! $editing ? json_encode($choixes ?? []) : '[]' !!};

function createChoice(value='', placeholder='New Choice') {
    const div = document.createElement('div');
    div.className = 'choice-item';
    const input = document.createElement('input');
    input.type='text'; input.name='choices[]'; input.className='input';
    input.value=value; input.placeholder=placeholder;
    const btn = document.createElement('button');
    btn.type='button'; btn.className='remove-btn'; btn.innerText='−';
    btn.onclick = () => div.remove();
    div.appendChild(input); div.appendChild(btn);
    document.getElementById('choices-container').appendChild(div);
}

function addChoice() { createChoice(); }

function setVoteType(type) {
    document.getElementById('vote_method_input').value = type;
    const s = type === 'select_one';
    document.getElementById('btn_single').style.borderColor = s ? '#1a73e8' : '#e0e0e0';
    document.getElementById('btn_single').style.background  = s ? '#e8f0fe' : '#f5f7fa';
    document.getElementById('btn_multi').style.borderColor  = s ? '#e0e0e0' : '#1a73e8';
    document.getElementById('btn_multi').style.background   = s ? '#f5f7fa' : '#e8f0fe';
    document.getElementById('max_choices_row').style.display = s ? 'none' : 'block';
}

function selectChoiceType(type, card) {
    document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    document.getElementById('choice_type_input').value = type;
    const c = document.getElementById('choices-container');
    c.innerHTML = '';
    if(type==='custom')      createChoice('','Choice 1');
    if(type==='percentage')  ['0','50','100'].forEach(v => createChoice(v));
    if(type==='scale')       for(let i=1;i<=10;i++) createChoice(i);
    if(type==='fibonacci')   [1,2,3,5,8,13].forEach(v => createChoice(v));
    if(type==='countries')   openCountryPicker();
}

function importChoices(input) {
    const file = input.files[0]; if(!file) return;
    const reader = new FileReader();
    reader.onload = e => e.target.result.split(/\r?\n/).map(l=>l.trim()).filter(l=>l).forEach(l=>createChoice(l));
    reader.readAsText(file);
    input.value='';
}

window.onload = () => {
    if(IS_EDITING) {
        if(EDIT_CHOICES.length > 0) {
            EDIT_CHOICES.forEach(c => createChoice(c.name));
        } else {
            createChoice('', 'Choice 1');
        }
    } else {
        createChoice('', 'Choice 1');
    }
};
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
function openCountryPicker() { document.getElementById('picker-search').value=''; document.getElementById('picker-modal').style.display='flex'; renderPicker(COUNTRIES); }
function closePicker() { document.getElementById('picker-modal').style.display='none'; }
function filterPicker(q) { renderPicker(COUNTRIES.filter(c=>c.name.toLowerCase().includes(q.toLowerCase()))); }
function renderPicker(items) {
    const list = document.getElementById('picker-list');
    list.innerHTML = items.map(c => {
        const exists = [...document.querySelectorAll('#choices-container input')].some(i=>i.value===c.name);
        return `<div onclick="toggleCountry('${c.name.replace(/'/g,"\\'")}')"
            style="padding:10px 20px;cursor:pointer;display:flex;align-items:center;gap:12px;font-size:13px;background:${exists?'#e8f0fe':'#fff'};">
            <img src="https://flagcdn.com/24x18/${c.code}.png" width="24" height="18" style="border-radius:3px;">
            <span style="flex:1;">${c.name}</span>
            <span>${exists?'✅':''}</span>
        </div>`;
    }).join('');
}
function toggleCountry(name) {
    const existing = [...document.querySelectorAll('#choices-container input')].find(i=>i.value===name);
    existing ? existing.closest('.choice-item').remove() : createChoice(name);
    filterPicker(document.getElementById('picker-search').value);
}
</script>
</body>
</html>
