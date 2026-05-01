<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ isset($editTopic) ? 'Edit Topic' : 'New Topic' }} — {{ $data->name }}</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
.material-symbols-rounded{font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;font-size:22px;line-height:1;}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f0f2f8;color:#1a1a2e;min-height:100vh;}

/* ── Page header ── */
.page-header{background:#fff;border-bottom:1px solid #e4e8f0;padding:18px 40px;display:flex;align-items:center;gap:14px;margin-bottom:32px;}
.page-header .breadcrumb{font-size:12px;color:#888;display:flex;align-items:center;gap:6px;}
.page-header .breadcrumb a{color:#1a73e8;text-decoration:none;font-weight:600;}
.page-header .breadcrumb span{color:#bbb;}
.page-title{font-size:20px;font-weight:800;color:#1a1a2e;display:flex;align-items:center;gap:10px;}
.page-badge{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;padding:5px 16px;border-radius:20px;font-size:12px;font-weight:700;letter-spacing:.4px;}
.page-badge.edit{background:linear-gradient(135deg,#f59e0b,#fbbf24);}

/* ── Layout ── */
.wrapper{max-width:1400px;margin:0 auto;padding:0 32px 48px;}
.layout{display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}.page-header{padding:14px 20px;}.wrapper{padding:0 16px 40px;}}

/* ── Cards ── */
.card{background:#fff;border-radius:20px;box-shadow:0 2px 16px rgba(0,0,0,0.07);border:1px solid #e8ecf4;overflow:hidden;}
.card-header{padding:18px 24px;border-bottom:1px solid #f0f2f8;display:flex;align-items:center;gap:10px;}
.card-header .icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.card-header .icon.blue{background:#e8f0fe;}
.card-header .icon.green{background:#e6f9f0;}
.card-header h2{font-size:15px;font-weight:800;color:#1a1a2e;}
.card-header p{font-size:12px;color:#888;margin-top:1px;}
.card-body{padding:24px;}

/* ── Form elements ── */
.field{margin-bottom:0;}
.label{display:block;font-size:11px;font-weight:700;color:#5a6a8a;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;}
.input{width:100%;background:#f7f9fc;border:2px solid #e4e8f0;padding:10px 13px;border-radius:10px;color:#1a1a2e;outline:none;transition:.2s;font-size:14px;}
.input:focus{border-color:#1a73e8;background:#fff;box-shadow:0 0 0 3px rgba(26,115,232,.08);}
.input.is-invalid{border-color:#e74c3c!important;background:#fff8f8;}
.input.is-valid{border-color:#27ae60!important;}
.field-error{color:#e74c3c;font-size:11px;font-weight:600;margin-top:4px;display:none;}
.field-error.show{display:block;}

/* ── Form grid rows ── */
.form-row{display:grid;gap:16px;margin-bottom:16px;}
.form-row.col-3{grid-template-columns:2fr 1fr 1fr;}
.form-row.col-choices{grid-template-columns:1fr 1fr;height:320px;}
@media(max-width:700px){.form-row.col-3,.form-row.col-choices{grid-template-columns:1fr;}.form-row.col-choices{height:auto;}}

/* ── Vote type toggle ── */
.vote-toggle{display:grid;grid-template-columns:1fr 1fr;gap:8px;}
.vote-btn{padding:11px 8px;border:2px solid #e4e8f0;border-radius:10px;text-align:center;cursor:pointer;background:#f7f9fc;font-weight:700;font-size:13px;transition:.2s;user-select:none;}
.vote-btn:hover{border-color:#1a73e8;background:#eef4ff;}
.vote-btn.active{border-color:#1a73e8;background:#e8f0fe;color:#1a73e8;}

/* ── Choice type box (LEFT) ── */
.section-box{border:2px solid #e4e8f0;border-radius:12px;padding:16px;background:#fafbfd;height:100%;display:flex;flex-direction:column;overflow:hidden;}
.method-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:8px;overflow-y:auto;flex:1;min-height:0;padding-right:2px;}
.method-card{display:flex;flex-direction:column;align-items:center;gap:5px;padding:14px 6px;border:2px solid #e4e8f0;border-radius:10px;cursor:pointer;transition:.18s;background:#fff;text-align:center;user-select:none;}
.method-card:hover{border-color:#1a73e8;background:#eef4ff;}
.method-card.active{border-color:#1a73e8;background:#e8f0fe;}
.method-card .name{font-size:13px;font-weight:700;color:#1a1a2e;}
.method-card .desc{font-size:11px;color:#888;}

/* ── Choices list box (RIGHT) ── */
.choices-box{border:2px solid #e4e8f0;border-radius:12px;padding:16px;background:#fafbfd;height:100%;display:flex;flex-direction:column;overflow:hidden;}
#choices-container{flex:1;overflow-y:auto;min-height:0;margin-bottom:10px;}
.choice-item{display:flex;gap:7px;margin-bottom:8px;}
.choice-item .input{flex:1;padding:9px 12px;}
.btn-remove{background:#fde8e8;color:#e74c3c;border:none;padding:9px 12px;border-radius:8px;cursor:pointer;font-size:15px;font-weight:700;flex-shrink:0;transition:.2s;}
.btn-remove:hover{background:#e74c3c;color:#fff;}
.btn-add-row{display:flex;gap:8px;flex-shrink:0;}
.btn-add{background:#f0f2f8;color:#5a6a8a;border:none;padding:9px 14px;border-radius:8px;cursor:pointer;font-size:12px;font-weight:600;transition:.2s;}
.btn-add:hover{background:#e4e8f0;color:#1a1a2e;}

/* ── Buttons ── */
button{border:none;cursor:pointer;font-weight:700;transition:.2s;}
.btn-primary{background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;width:100%;padding:13px;border-radius:12px;font-size:14px;box-shadow:0 4px 12px rgba(26,115,232,.25);}
.btn-primary:hover{background:linear-gradient(135deg,#1558b0,#1a73e8);box-shadow:0 6px 16px rgba(26,115,232,.35);}
.btn-cancel{display:block;text-align:center;background:#f0f2f8;color:#5a6a8a;width:100%;padding:12px;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;margin-top:10px;transition:.2s;}
.btn-cancel:hover{background:#e4e8f0;color:#1a1a2e;}
.btn-start{background:linear-gradient(135deg,#27ae60,#2ecc71);color:#fff;width:100%;padding:13px;border-radius:12px;font-size:14px;box-shadow:0 4px 12px rgba(39,174,96,.25);margin-bottom:0;}
.btn-start:hover{background:linear-gradient(135deg,#219a52,#27ae60);}
.btn-started{background:#e4e8f0;color:#aaa;width:100%;padding:13px;border-radius:12px;font-size:14px;cursor:not-allowed;}
.form-actions{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px;}
.form-actions .btn-primary{margin:0;}

/* ── Topics list ── */
.topics-count{background:#e8f0fe;color:#1a73e8;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;}
.topics-scroll{max-height:380px;overflow-y:auto;padding-right:2px;}
.topic-item{display:flex;align-items:center;gap:8px;background:#f7f9fc;padding:9px 11px;border-radius:11px;margin-bottom:7px;border:2px solid #e4e8f0;transition:.2s;}
.topic-item:hover{border-color:#1a73e8;background:#eef4ff;}
.topic-item.active-edit{border-color:#1a73e8;background:#e8f0fe;}
.topic-num{background:#e4e8f0;color:#5a6a8a;padding:3px 8px;border-radius:6px;font-size:12px;font-weight:800;flex-shrink:0;}
.topic-item.active-edit .topic-num{background:#1a73e8;color:#fff;}
.topic-name{font-size:13px;font-weight:600;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.topic-time{background:#1a73e8;color:#fff;padding:3px 7px;border-radius:6px;font-size:11px;font-weight:700;flex-shrink:0;}
.topic-actions{display:flex;gap:4px;flex-shrink:0;}
.q-edit-btn{background:#e8f0fe;color:#1a73e8;border:none;padding:5px 8px;border-radius:6px;cursor:pointer;font-size:11px;font-weight:700;transition:.2s;}
.q-edit-btn:hover{background:#1a73e8;color:#fff;}
.q-del-btn{background:#fde8e8;color:#e74c3c;border:none;padding:5px 8px;border-radius:6px;cursor:pointer;font-size:11px;font-weight:700;transition:.2s;}
.q-del-btn:hover{background:#e74c3c;color:#fff;}
.no-topics{text-align:center;padding:28px 0;color:#bbb;font-size:13px;}
.no-topics .icon{font-size:28px;margin-bottom:6px;}

/* ── Divider ── */
.divider{height:1px;background:#f0f2f8;margin:14px 0;}
</style>
</head>
<body>
@include('components.navbar')
@include('components.toast')

@php $editing = isset($editTopic); @endphp

<!-- Page Header -->
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <a href="/dashboard">Room</a>
            <span>›</span>
            <a href="/show/{{ $data->id }}">{{ $data->name }}</a>
            <span>›</span>
            <span>{{ $editing ? 'Edit Topic' : 'New Topic' }}</span>
        </div>
        <div class="page-title" style="margin-top:6px;">
            <span class="page-badge {{ $editing ? 'edit' : '' }}">
                {{ $editing ? '✏️ Edit Topic' : '➕ New Topic' }}
            </span>
            <span style="font-size:15px;color:#5a6a8a;font-weight:600;">Room: {{ $data->name }}</span>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="layout">

        <!-- LEFT: Form -->
        <div class="card">
            <div class="card-header">
                <div class="icon blue">{{ $editing ? '✏️' : '📝' }}</div>
                <div>
                    <h2>{{ $editing ? 'Edit Topic' : 'Create New Topic' }}</h2>
                    <p>{{ $editing ? 'Update the topic details below' : 'Fill in the details to add a new voting topic' }}</p>
                </div>
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ $editing ? '/rooms/'.$data->id.'/topics/'.$editTopic->id : '/rooms/'.$data->id.'/topic' }}"
                      id="topicForm">
                    @csrf
                    @php
                        $vm      = $editing ? $editTopic->vote_methode : 'select_one';
                        $isMulti = $vm === 'select_multiple';
                    @endphp

                    <!-- Row 1: Topic Name + Vote Type + Duration -->
                    <div class="form-row col-3">
                        <div class="field">
                            <label class="label">Topic Name</label>
                            <input type="text" name="topic_name" id="topic_name" class="input"
                                   placeholder="e.g. Best Framework…"
                                   value="{{ $editing ? $editTopic->name : '' }}">
                            <span class="field-error" id="err_topic_name">Min 2 characters required.</span>
                        </div>
                        <div class="field">
                            <label class="label">Vote Type</label>
                            <input type="hidden" name="vote_method" id="vote_method_input" value="{{ $vm }}">
                            <div class="vote-toggle">
                                <div id="btn_single" class="vote-btn {{ !$isMulti ? 'active' : '' }}" onclick="setVoteType('select_one')">Single</div>
                                <div id="btn_multi" class="vote-btn {{ $isMulti ? 'active' : '' }}" onclick="setVoteType('select_multiple')">Multiple</div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Duration</label>
                            <select name="duration" class="input" style="cursor:pointer;">
                                @foreach(['00:00:15'=>'15 sec','00:00:30'=>'30 sec','00:01:00'=>'1 min','00:02:00'=>'2 min','00:03:00'=>'3 min','00:05:00'=>'5 min'] as $val=>$lbl)
                                <option value="{{ $val }}" {{ ($editing && $editTopic->duration==$val) ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Max choices (shown only for multiple) -->
                    <div id="max_choices_row" style="display:{{ $isMulti ? 'block' : 'none' }};margin-bottom:14px;">
                        <label class="label">Max Choices Allowed</label>
                        <input type="number" name="max_choices" id="max_choices_input" class="input"
                               value="{{ $editing ? $editTopic->max_choices : 2 }}" min="2" max="20" style="width:130px;">
                    </div>

                    <div class="divider"></div>

                    <!-- Row 2: Choice Type (left) + Choices list (right) -->
                    <div class="form-row col-choices" style="align-items:stretch;">
                        <!-- Choice Type -->
                        <div class="section-box">
                            <label class="label" style="margin-bottom:8px;">Choice Type</label>
                            <input type="hidden" name="choice_type" id="choice_type_input" value="custom">
                            <div class="method-grid">
                                <div class="method-card active" onclick="selectChoiceType('custom',this)"><span class="name">Custom</span><span class="desc">Your own</span></div>
                                <div class="method-card" onclick="selectChoiceType('percentage',this)"><span class="name">%</span><span class="desc">0–50–100</span></div>
                                <div class="method-card" onclick="selectChoiceType('scale',this)"><span class="name">1–10</span><span class="desc">Scale</span></div>
                                <div class="method-card" onclick="selectChoiceType('fibonacci',this)"><span class="name">Fib</span><span class="desc">1,2,3,5…</span></div>
                                <div class="method-card" onclick="selectChoiceType('countries',this)"><span class="name">🌍</span><span class="desc">Countries</span></div>
                                <div class="method-card" onclick="openDatePicker(this)"><span class="name">📅</span><span class="desc">Dates</span></div>
                                <div class="method-card" onclick="openColorPicker(this)"><span class="name">🎨</span><span class="desc">Colors</span></div>
                                <div class="method-card" onclick="openRatingPicker(this)"><span class="name">⭐</span><span class="desc">Rating</span></div>
                                <div class="method-card" onclick="openRankingPicker(this)"><span class="name">🏆</span><span class="desc">Ranking</span></div>
                                <div class="method-card" onclick="openMoodPicker(this)"><span class="name">🌡️</span><span class="desc">Mood</span></div>
                                <label class="method-card" style="cursor:pointer;"><span class="name">📂</span><span class="desc">Import</span><input type="file" accept=".txt,.csv" style="display:none;" onchange="importChoices(this)"></label>
                            </div>
                        </div>
                        <!-- Choices list -->
                        <div class="choices-box">
                            <label class="label" style="margin-bottom:8px;">Choices</label>
                            <div id="choices-container"></div>
                            <div class="btn-add-row">
                                <button type="button" class="btn-add" onclick="addChoice()">+ Add</button>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn-primary" onclick="submitTopicForm()">
                            {{ $editing ? '💾 Save Changes' : '✅ Save Topic' }}
                        </button>
                        @if($editing)
                        <a href="/show/{{ $data->id }}" style="text-decoration:none;">
                            <button type="button" class="btn-cancel" style="width:100%;margin:0;">✕ Cancel</button>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT: Topics List + Start Room -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Start Room Card -->
            <div class="card">
                <div class="card-body" style="padding:18px;">
                    <form method="GET" action="/rooms/{{$data->id}}/start">
                        @if($data->status !== 'started')
                            <button type="submit" class="btn-start">▶ Start Room</button>
                        @else
                            <button type="button" disabled class="btn-started">✅ Room Started</button>
                        @endif
                    </form>
                    <div style="margin-top:12px;padding:10px 14px;background:#f7f9fc;border-radius:10px;border:1px solid #e4e8f0;">
                        <div style="font-size:11px;color:#888;font-weight:600;text-transform:uppercase;letter-spacing:.4px;">Room Code</div>
                        <div style="font-size:20px;font-weight:800;color:#1a73e8;letter-spacing:4px;margin-top:2px;">{{ $data->code }}</div>
                    </div>
                </div>
            </div>

            <!-- Topics List Card -->
            <div class="card">
                <div class="card-header">
                    <div class="icon green">📋</div>
                    <div style="flex:1;">
                        <div class="topics-header" style="margin-bottom:0;">
                            <h2>Topics</h2>
                            <span class="topics-count">{{ $topics->count() }}</span>
                        </div>
                        <p>All topics in this room</p>
                    </div>
                </div>
                <div class="card-body" style="padding:16px;">
                    <div class="topics-scroll">
                    @forelse($topics as $index => $q)
                    <div class="topic-item {{ ($editing && $editTopic->id == $q->id) ? 'active-edit' : '' }}">
                        <span class="topic-num">{{ $index+1 }}</span>
                        <span class="topic-name" title="{{ $q->name }}">{{ $q->name }}</span>
                        <span class="topic-time">{{ $q->duration }}</span>
                        <div class="topic-actions">
                            <a href="/rooms/{{$data->id}}/topics/{{$q->id}}/edit">
                                <button type="button" class="q-edit-btn">✏</button>
                            </a>
                            <form method="POST" action="/rooms/{{$data->id}}/topics/{{$q->id}}"
                                  onsubmit="return confirm('Delete this topic?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="q-del-btn">🗑</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="no-topics">
                        <div class="icon">📭</div>
                        <div>No topics yet</div>
                        <div style="font-size:11px;margin-top:4px;">Create your first topic using the form</div>
                    </div>
                    @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
const IS_EDITING   = {{ $editing ? 'true' : 'false' }};
const EDIT_CHOICES = {!! $editing ? json_encode($choixes ?? []) : '[]' !!};

function createChoice(value='', placeholder='New Choice') {
    const div = document.createElement('div');
    div.className = 'choice-item';
    const input = document.createElement('input');
    input.type='text'; input.name='choices[]'; input.className='input';
    input.value=value; input.placeholder=placeholder;
    const btn = document.createElement('button');
    btn.type='button'; btn.className='btn-remove'; btn.innerText='−';
    btn.onclick = () => div.remove();
    div.appendChild(input); div.appendChild(btn);
    document.getElementById('choices-container').appendChild(div);
}

function addChoice() { createChoice(); }

function setVoteType(type) {
    document.getElementById('vote_method_input').value = type;
    const s = type === 'select_one';
    document.getElementById('btn_single').classList.toggle('active', s);
    document.getElementById('btn_multi').classList.toggle('active', !s);
    document.getElementById('max_choices_row').style.display = s ? 'none' : 'block';
}

function openPickerModal(id, card, type) {
    document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    document.getElementById('choice_type_input').value = type;
    document.getElementById(id).style.display = 'flex';
}
function closeModal(id) { document.getElementById(id).style.display = 'none'; }
function applyModal(id) {
    const checked = [...document.querySelectorAll('#'+id+' input[type=checkbox]:checked')];
    if (!checked.length) { closeModal(id); return; }
    document.getElementById('choices-container').innerHTML = '';
    checked.forEach(cb => createChoice(cb.value));
    closeModal(id);
}
function clearModal(id) {
    document.querySelectorAll('#'+id+' input[type=checkbox]').forEach(c => {
        c.checked = false;
        c.closest('label').style.borderColor = '#e4e8f0';
        c.closest('label').style.background  = '#fff';
    });
}
function openColorPicker(card)   { openPickerModal('color-modal',   card, 'colors');   }
function openRatingPicker(card)  { openPickerModal('rating-modal',  card, 'rating');   }
function openRankingPicker(card) { openPickerModal('ranking-modal', card, 'ranking');  }
function openMoodPicker(card)    { openPickerModal('mood-modal',    card, 'mood');     }

function openDatePicker(card) {
    document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    document.getElementById('choice_type_input').value = 'dates';
    showDateTab('days');
    document.getElementById('date-modal').style.display = 'flex';
}
function closeDateModal() { document.getElementById('date-modal').style.display = 'none'; }
function showDateTab(tab) {
    document.getElementById('tab-days').classList.toggle('date-tab-active', tab==='days');
    document.getElementById('tab-months').classList.toggle('date-tab-active', tab==='months');
    document.getElementById('panel-days').style.display   = tab==='days'   ? 'block' : 'none';
    document.getElementById('panel-months').style.display = tab==='months' ? 'block' : 'none';
}
function applyDates() {
    const checked = [...document.querySelectorAll('#date-modal input[type=checkbox]:checked')];
    if (!checked.length) { closeDateModal(); return; }
    document.getElementById('choices-container').innerHTML = '';
    checked.forEach(cb => createChoice(cb.value));
    closeDateModal();
}

function openTimeSlotPicker(card) {
    document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    document.getElementById('choice_type_input').value = 'timeslots';
    document.getElementById('timeslot-modal').style.display = 'flex';
}
function closeTimeSlotModal() { document.getElementById('timeslot-modal').style.display = 'none'; }
function applyTimeSlots() {
    const checked = [...document.querySelectorAll('#timeslot-modal input[type=checkbox]:checked')];
    if (!checked.length) { closeTimeSlotModal(); return; }
    document.getElementById('choices-container').innerHTML = '';
    checked.forEach(cb => createChoice(cb.value));
    closeTimeSlotModal();
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
    if(IS_EDITING && EDIT_CHOICES.length > 0) {
        EDIT_CHOICES.forEach(c => createChoice(c.name));
    } else {
        createChoice('', 'Choice 1');
    }
};

function validateField(input, errorId, condition, msg) {
    const err = document.getElementById(errorId);
    if (!condition) {
        input.classList.add('is-invalid'); input.classList.remove('is-valid');
        err.textContent = msg; err.classList.add('show');
        return false;
    }
    input.classList.remove('is-invalid'); input.classList.add('is-valid');
    err.classList.remove('show');
    return true;
}

function submitTopicForm() {
    let valid = true;
    const nameInput = document.getElementById('topic_name');
    valid &= validateField(nameInput, 'err_topic_name', nameInput.value.trim().length >= 2, 'Topic name is required (min 2 characters).');
    const choices = [...document.querySelectorAll('#choices-container input[name="choices[]"]')]
        .map(i => i.value.trim()).filter(v => v !== '');
    if (choices.length < 1) {
        valid = false;
        let errEl = document.getElementById('err_choices');
        if (!errEl) {
            errEl = document.createElement('span');
            errEl.id = 'err_choices'; errEl.className = 'field-error show';
            document.getElementById('choices-container').parentNode.insertBefore(errEl, document.getElementById('choices-container').nextSibling);
        }
        errEl.textContent = 'At least one choice is required.';
        errEl.classList.add('show');
    } else {
        const errEl = document.getElementById('err_choices');
        if (errEl) errEl.classList.remove('show');
    }
    if (valid) document.getElementById('topicForm').submit();
}

document.addEventListener('input', e => {
    if (e.target.id === 'topic_name')
        validateField(e.target, 'err_topic_name', e.target.value.trim().length >= 2, 'Topic name is required (min 2 characters).');
});
</script>

<!-- Color Picker Modal -->
<div id="color-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:18px;width:420px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,0.2);">
        <div style="padding:16px 22px;border-bottom:1px solid #f0f2f8;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:800;font-size:15px;">🎨 Select Colors</span>
            <button onclick="closeModal('color-modal')" style="background:#f0f2f8;border:none;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer;color:#888;">&times;</button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:16px 22px;">
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;">
                @foreach(['🔴'=>'Red','🟠'=>'Orange','🟡'=>'Yellow','🟢'=>'Green','🔵'=>'Blue','🟣'=>'Purple','🟤'=>'Brown','🟥'=>'Pink','⚫'=>'Black','⚪'=>'White','🟦'=>'Teal','🟧'=>'Violet'] as $emoji=>$name)
                <label style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 6px;border:2px solid #e4e8f0;border-radius:10px;cursor:pointer;background:#fff;transition:.18s;" onmouseover="this.style.borderColor='#1a73e8'" onmouseout="this.style.borderColor=this.querySelector('input').checked?'#1a73e8':'#e4e8f0'">
                    <input type="checkbox" value="{{ $emoji }} {{ $name }}" style="display:none;" onchange="this.closest('label').style.borderColor=this.checked?'#1a73e8':'#e4e8f0';this.closest('label').style.background=this.checked?'#e8f0fe':'#fff';">
                    <span style="font-size:26px;">{{ $emoji }}</span>
                    <span style="font-size:11px;font-weight:700;color:#1a1a2e;">{{ $name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div style="padding:14px 22px;border-top:1px solid #f0f2f8;display:flex;justify-content:space-between;">
            <button onclick="clearModal('color-modal')" style="background:#f0f2f8;color:#5a6a8a;border:none;padding:9px 16px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">Clear</button>
            <button onclick="applyModal('color-modal')" style="background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;border:none;padding:9px 22px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">✅ Apply</button>
        </div>
    </div>
</div>

<!-- Rating Picker Modal -->
<div id="rating-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:18px;width:380px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,0.2);">
        <div style="padding:16px 22px;border-bottom:1px solid #f0f2f8;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:800;font-size:15px;">⭐ Select Rating Stars</span>
            <button onclick="closeModal('rating-modal')" style="background:#f0f2f8;border:none;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer;color:#888;">&times;</button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:16px 22px;">
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach([1,2,3,4,5] as $s)
                <label style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:2px solid #e4e8f0;border-radius:12px;cursor:pointer;background:#fff;transition:.18s;" onmouseover="this.style.borderColor='#1a73e8'" onmouseout="this.style.borderColor=this.querySelector('input').checked?'#1a73e8':'#e4e8f0'">
                    <input type="checkbox" value="{{ str_repeat('⭐',$s) }} {{ $s }} Star{{ $s>1?'s':'' }}" style="display:none;" onchange="this.closest('label').style.borderColor=this.checked?'#1a73e8':'#e4e8f0';this.closest('label').style.background=this.checked?'#e8f0fe':'#fff';">
                    <span style="font-size:20px;">{{ str_repeat('⭐',$s) }}</span>
                    <span style="font-size:13px;font-weight:700;color:#1a1a2e;">{{ $s }} Star{{ $s>1?'s':'' }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div style="padding:14px 22px;border-top:1px solid #f0f2f8;display:flex;justify-content:space-between;">
            <button onclick="clearModal('rating-modal')" style="background:#f0f2f8;color:#5a6a8a;border:none;padding:9px 16px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">Clear</button>
            <button onclick="applyModal('rating-modal')" style="background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;border:none;padding:9px 22px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">✅ Apply</button>
        </div>
    </div>
</div>

<!-- Ranking Picker Modal -->
<div id="ranking-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:18px;width:380px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,0.2);">
        <div style="padding:16px 22px;border-bottom:1px solid #f0f2f8;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:800;font-size:15px;">🏆 Select Ranking Positions</span>
            <button onclick="closeModal('ranking-modal')" style="background:#f0f2f8;border:none;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer;color:#888;">&times;</button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:16px 22px;">
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach(['🥇'=>'1st Place','🥈'=>'2nd Place','🥉'=>'3rd Place','🔵'=>'4th Place','🟡'=>'5th Place','🟢'=>'6th Place','🟠'=>'7th Place','🔴'=>'8th Place'] as $emoji=>$label)
                <label style="display:flex;align-items:center;gap:14px;padding:14px 16px;border:2px solid #e4e8f0;border-radius:12px;cursor:pointer;background:#fff;transition:.18s;" onmouseover="this.style.borderColor='#1a73e8'" onmouseout="this.style.borderColor=this.querySelector('input').checked?'#1a73e8':'#e4e8f0'">
                    <input type="checkbox" value="{{ $emoji }} {{ $label }}" style="display:none;" onchange="this.closest('label').style.borderColor=this.checked?'#1a73e8':'#e4e8f0';this.closest('label').style.background=this.checked?'#e8f0fe':'#fff';">
                    <span style="font-size:22px;">{{ $emoji }}</span>
                    <span style="font-size:13px;font-weight:700;color:#1a1a2e;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div style="padding:14px 22px;border-top:1px solid #f0f2f8;display:flex;justify-content:space-between;">
            <button onclick="clearModal('ranking-modal')" style="background:#f0f2f8;color:#5a6a8a;border:none;padding:9px 16px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">Clear</button>
            <button onclick="applyModal('ranking-modal')" style="background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;border:none;padding:9px 22px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">✅ Apply</button>
        </div>
    </div>
</div>

<!-- Mood Picker Modal -->
<div id="mood-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:18px;width:420px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,0.2);">
        <div style="padding:16px 22px;border-bottom:1px solid #f0f2f8;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:800;font-size:15px;">🌡️ Select Mood</span>
            <button onclick="closeModal('mood-modal')" style="background:#f0f2f8;border:none;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer;color:#888;">&times;</button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:16px 22px;">
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                @foreach(['😄'=>'Very Happy','😊'=>'Happy','🙂'=>'Slightly Happy','😐'=>'Neutral','😕'=>'Unsure','🙁'=>'Slightly Sad','😞'=>'Sad','😢'=>'Very Sad','😡'=>'Angry','🤯'=>'Mind Blown','🤔'=>'Thinking','😱'=>'Shocked'] as $emoji=>$label)
                <label style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 6px;border:2px solid #e4e8f0;border-radius:10px;cursor:pointer;background:#fff;transition:.18s;" onmouseover="this.style.borderColor='#1a73e8'" onmouseout="this.style.borderColor=this.querySelector('input').checked?'#1a73e8':'#e4e8f0'">
                    <input type="checkbox" value="{{ $emoji }} {{ $label }}" style="display:none;" onchange="this.closest('label').style.borderColor=this.checked?'#1a73e8':'#e4e8f0';this.closest('label').style.background=this.checked?'#e8f0fe':'#fff';">
                    <span style="font-size:28px;">{{ $emoji }}</span>
                    <span style="font-size:11px;font-weight:700;color:#1a1a2e;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div style="padding:14px 22px;border-top:1px solid #f0f2f8;display:flex;justify-content:space-between;">
            <button onclick="clearModal('mood-modal')" style="background:#f0f2f8;color:#5a6a8a;border:none;padding:9px 16px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">Clear</button>
            <button onclick="applyModal('mood-modal')" style="background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;border:none;padding:9px 22px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">✅ Apply</button>
        </div>
    </div>
</div>

<!-- Date Picker Modal -->
<div id="date-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:18px;width:460px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,0.2);">
        <div style="padding:16px 22px;border-bottom:1px solid #f0f2f8;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:800;font-size:15px;">📅 Select Dates</span>
            <button onclick="closeDateModal()" style="background:#f0f2f8;border:none;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer;color:#888;">&times;</button>
        </div>
        <!-- Tabs -->
        <div style="display:flex;gap:0;border-bottom:1px solid #f0f2f8;">
            <button id="tab-days" onclick="showDateTab('days')" class="date-tab date-tab-active">Days of Week</button>
            <button id="tab-months" onclick="showDateTab('months')" class="date-tab">Months</button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:16px 22px;">
            <!-- Days panel -->
            <div id="panel-days">
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;">
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <label style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px 6px;border:2px solid #e4e8f0;border-radius:10px;cursor:pointer;transition:.18s;background:#fff;" onmouseover="this.style.borderColor='#1a73e8'" onmouseout="this.style.borderColor=this.querySelector('input').checked?'#1a73e8':'#e4e8f0'">
                        <input type="checkbox" value="{{ $day }}" style="display:none;" onchange="this.closest('label').style.borderColor=this.checked?'#1a73e8':'#e4e8f0';this.closest('label').style.background=this.checked?'#e8f0fe':'#fff';">
                        <span style="font-size:20px;">{{ ['Monday'=>'Mon','Tuesday'=>'Tue','Wednesday'=>'Wed','Thursday'=>'Thu','Friday'=>'Fri','Saturday'=>'Sat','Sunday'=>'Sun'][$day] }}</span>
                        <span style="font-size:11px;font-weight:700;color:#1a1a2e;">{{ $day }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <!-- Months panel -->
            <div id="panel-months" style="display:none;">
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;">
                    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                    <label style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px 6px;border:2px solid #e4e8f0;border-radius:10px;cursor:pointer;transition:.18s;background:#fff;" onmouseover="this.style.borderColor='#1a73e8'" onmouseout="this.style.borderColor=this.querySelector('input').checked?'#1a73e8':'#e4e8f0'">
                        <input type="checkbox" value="{{ $month }}" style="display:none;" onchange="this.closest('label').style.borderColor=this.checked?'#1a73e8':'#e4e8f0';this.closest('label').style.background=this.checked?'#e8f0fe':'#fff';">
                        <span style="font-size:18px;">{{ ['January'=>'Jan','February'=>'Feb','March'=>'Mar','April'=>'Apr','May'=>'May','June'=>'Jun','July'=>'Jul','August'=>'Aug','September'=>'Sep','October'=>'Oct','November'=>'Nov','December'=>'Dec'][$month] }}</span>
                        <span style="font-size:11px;font-weight:700;color:#1a1a2e;">{{ $month }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div style="padding:14px 22px;border-top:1px solid #f0f2f8;display:flex;justify-content:space-between;align-items:center;">
            <button onclick="document.querySelectorAll('#date-modal input[type=checkbox]').forEach(c=>{ c.checked=false; c.closest('label').style.borderColor='#e4e8f0'; c.closest('label').style.background='#fff'; })" style="background:#f0f2f8;color:#5a6a8a;border:none;padding:9px 16px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">Clear</button>
            <button onclick="applyDates()" style="background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;border:none;padding:9px 22px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">✅ Apply</button>
        </div>
    </div>
</div>
<style>
.date-tab{flex:1;padding:11px;border:none;background:#fff;font-weight:700;font-size:13px;color:#888;cursor:pointer;transition:.2s;}
.date-tab-active{color:#1a73e8;border-bottom:2px solid #1a73e8;background:#f7f9ff;}
</style>

<!-- Country Picker Modal -->
<div id="picker-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:18px;width:440px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,0.2);">
        <div style="padding:18px 22px;border-bottom:1px solid #f0f2f8;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:800;font-size:15px;">🌍 Select Countries</span>
            <button onclick="closePicker()" style="background:#f0f2f8;border:none;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer;color:#888;">&times;</button>
        </div>
        <div style="padding:12px 22px;border-bottom:1px solid #f0f2f8;">
            <input id="picker-search" type="text" placeholder="Search country…" oninput="filterPicker(this.value)"
                style="width:100%;padding:9px 14px;border:2px solid #e4e8f0;border-radius:10px;font-size:13px;outline:none;">
        </div>
        <div id="picker-list" style="overflow-y:auto;flex:1;padding:6px 0;"></div>
        <div style="padding:14px 22px;border-top:1px solid #f0f2f8;text-align:right;">
            <button onclick="closePicker()" style="background:linear-gradient(135deg,#1a73e8,#4f9cf9);color:#fff;border:none;padding:9px 22px;border-radius:10px;font-weight:700;cursor:pointer;font-size:13px;">Done</button>
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
            style="padding:10px 22px;cursor:pointer;display:flex;align-items:center;gap:12px;font-size:13px;background:${exists?'#e8f0fe':'#fff'};transition:.15s;">
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
