{{-- Flash Messages Partial --}}
{{-- $topOffset: CSS top offset string, e.g. '135px' or '75px' --}}
@php $topOffset = $topOffset ?? '135px'; @endphp

@if($errors->any())
    <div style="position: fixed; top: {{ $topOffset }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
        <div class="container">
            <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(231, 76, 60, 0.4); border-left: 5px solid #e74c3c; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <i class="fas fa-exclamation-circle" style="color: #e74c3c; font-size: 1.4rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                    <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">
                        <strong style="display: block; margin-bottom: 0.25rem; color: #b91c1c;">Please check the following:</strong>
                        @foreach($errors->all() as $error)
                            <div style="color: #475569;">{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
@endif

@if(session('success'))
    <div style="position: fixed; top: {{ $topOffset }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
        <div class="container">
            <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(13, 148, 136, 0.4); border-left: 5px solid #0d9488; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-check-circle" style="color: #0d9488; font-size: 1.4rem; flex-shrink: 0;"></i>
                    <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div style="position: fixed; top: {{ $topOffset }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
        <div class="container">
            <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(231, 76, 60, 0.4); border-left: 5px solid #e74c3c; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-exclamation-circle" style="color: #e74c3c; font-size: 1.4rem; flex-shrink: 0;"></i>
                    <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
@endif

@if(session('info'))
    <div style="position: fixed; top: {{ $topOffset }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
        <div class="container">
            <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(52, 152, 219, 0.4); border-left: 5px solid #3498db; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-info-circle" style="color: #3498db; font-size: 1.4rem; flex-shrink: 0;"></i>
                    <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">{{ session('info') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
@endif

<script>
    window.addEventListener('load', () => {
        document.querySelectorAll('.js-auto-dismiss').forEach((alertEl) => {
            setTimeout(() => {
                const closeBtn = alertEl.querySelector('.btn-close');
                if (closeBtn) { closeBtn.click(); return; }
                alertEl.classList.remove('show');
                alertEl.classList.add('hide');
            }, 4000);
        });
    });
</script>
