@if(session('success') || session('error') || session('status') || $errors->any())
<div id="sv-toast" class="sv-toast {{ session('error') || $errors->any() ? 'sv-toast--error' : '' }}">
    <div class="sv-toast__icon">
        @if(session('error') || $errors->any())
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        @else
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
        @endif
    </div>
    <span class="sv-toast__msg">
        @if(session('success'))
            {{ session('success') }}
        @elseif(session('status'))
            {{ session('status') }}
        @elseif(session('error'))
            {{ session('error') }}
        @else
            {{ $errors->first() }}
        @endif
    </span>
    <button class="sv-toast__close" onclick="svToastDismiss()">×</button>
</div>

<style>
.sv-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border-left: 4px solid #1a73e8;
    padding: 12px 16px;
    border-radius: 10px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.12);
    z-index: 99999;
    font-family: 'Segoe UI', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #1a1a2e;
    max-width: 320px;
    animation: svSlideIn 0.3s ease;
}
.sv-toast--error { border-left-color: #e74c3c; }
.sv-toast__icon {
    width: 24px; height: 24px;
    border-radius: 50%;
    background: #1a73e8;
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.sv-toast--error .sv-toast__icon { background: #e74c3c; }
.sv-toast__msg { flex: 1; line-height: 1.4; }
.sv-toast__close {
    background: none; border: none;
    font-size: 18px; color: #aaa;
    cursor: pointer; padding: 0 2px;
    line-height: 1; flex-shrink: 0;
}
.sv-toast__close:hover { color: #555; }
@keyframes svSlideIn {
    from { opacity: 0; transform: translateX(40px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes svSlideOut {
    to { opacity: 0; transform: translateX(40px); }
}
.sv-toast--out { animation: svSlideOut 0.3s ease forwards; }
</style>

<script>
(function () {
    function svToastDismiss() {
        var t = document.getElementById('sv-toast');
        if (!t) return;
        t.classList.add('sv-toast--out');
        setTimeout(function () { t && t.remove(); }, 300);
    }
    window.svToastDismiss = svToastDismiss;
    setTimeout(svToastDismiss, 2000);
})();
</script>
@endif
