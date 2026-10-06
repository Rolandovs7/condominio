@extends('plantilla')
@section('title', 'Registrar Pago')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-money-bill-wave me-2" style="color:#34d399;"></i> Registrar Pago</h2>
        <a href="{{ route('pagos.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-credit-card me-2"></i> Datos del pago
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pagos.store') }}" method="POST" id="pagoForm">
                        @csrf

                        {{-- Cuota --}}
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-file-invoice me-1"></i> Cuota asociada</label>
                            <select name="cuota_id" id="cuotaSelect" class="form-select" required>
                                <option value="">— Selecciona una cuota —</option>
                                @foreach($cuotas as $cuota)
                                <option value="{{ $cuota->id }}"
                                        data-monto="{{ $cuota->monto }}"
                                        {{ old('cuota_id', $cuotaPreseleccionada ?? '') == $cuota->id ? 'selected' : '' }}>
                                    Cuota #{{ $cuota->id }} — {{ $cuota->residente->nombre_completo ?? 'Sin residente' }}
                                    (Bs {{ number_format($cuota->monto, 2) }})
                                    {{ $cuota->titulo ? '· ' . $cuota->titulo : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Monto --}}
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-dollar-sign me-1"></i> Monto pagado (Bs)</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#1e293b;border:1px solid #334155;color:#34d399;font-weight:700;">Bs</span>
                                <input type="number" step="0.01" min="0.01"
                                       name="monto_pagado" id="montoPagado"
                                       class="form-control" required
                                       value="{{ old('monto_pagado') }}"
                                       placeholder="0.00">
                            </div>
                            <div style="font-size:.75rem;color:#64748b;margin-top:.4rem;">
                                <i class="fas fa-info-circle me-1"></i> Se llena automáticamente al seleccionar la cuota.
                            </div>
                        </div>

                        {{-- Fecha --}}
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-calendar me-1"></i> Fecha de pago</label>
                            <input type="text" class="form-control"
                                   value="{{ now()->format('d/m/Y H:i') }}" disabled
                                   style="color:#64748b;">
                            <input type="hidden" name="fecha_pago" value="{{ now()->toDateTimeString() }}">
                        </div>

                        {{-- Método --}}
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-wallet me-1"></i> Método de pago</label>
                            <div class="row g-2">
                                @foreach([
                                    ['efectivo',      'fa-money-bill-wave', '#34d399', 'Efectivo'],
                                    ['transferencia', 'fa-university',      '#38bdf8', 'Transferencia'],
                                    ['qr',            'fa-qrcode',          '#a78bfa', 'QR'],
                                    ['stripe',        'fa-credit-card',     '#fbbf24', 'Tarjeta (Stripe)'],
                                ] as [$val, $icon, $color, $label])
                                <div class="col-6">
                                    <label style="cursor:pointer;">
                                        <input type="radio" name="metodo" value="{{ $val }}"
                                               {{ old('metodo') == $val ? 'checked' : '' }}
                                               style="display:none;" class="metodo-radio">
                                        <div class="metodo-card p-3 text-center rounded-3"
                                             style="border:2px solid rgba(255,255,255,.08);transition:all .2s;background:rgba(255,255,255,.03);">
                                            <i class="fas {{ $icon }} mb-2" style="font-size:1.4rem;color:{{ $color }};"></i>
                                            <div style="font-size:.82rem;font-weight:600;color:#cbd5e1;">{{ $label }}</div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="metodo" id="metodoHidden" value="{{ old('metodo') }}">
                        </div>

                        {{-- Observación --}}
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-comment me-1"></i> Observación <span style="color:#475569;">(opcional)</span></label>
                            <textarea name="observacion" class="form-control" rows="2"
                                      placeholder="Ej: Pago parcial, referencia de transferencia...">{{ old('observacion') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                <i class="fas fa-check me-2"></i> Registrar pago
                            </button>
                            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('css')
<style>
.metodo-card:hover { border-color: rgba(255,255,255,.2) !important; background: rgba(255,255,255,.06) !important; }
.metodo-card.selected { border-color: #2563eb !important; background: rgba(37,99,235,.12) !important; }
</style>
@endpush

@push('js')
<script>
// Auto-fill monto al seleccionar cuota
document.getElementById('cuotaSelect').addEventListener('change', function() {
    const sel  = this.options[this.selectedIndex];
    const mont = sel.getAttribute('data-monto');
    document.getElementById('montoPagado').value = mont ? parseFloat(mont).toFixed(2) : '';
});

// Trigger on load if preselected
if (document.getElementById('cuotaSelect').value) {
    document.getElementById('cuotaSelect').dispatchEvent(new Event('change'));
}

// Método de pago visual
document.querySelectorAll('.metodo-radio').forEach(radio => {
    radio.closest('label').addEventListener('click', function() {
        document.querySelectorAll('.metodo-card').forEach(c => c.classList.remove('selected'));
        this.querySelector('.metodo-card').classList.add('selected');
        document.getElementById('metodoHidden').value = this.querySelector('.metodo-radio').value;
    });
});

// Botón submit con loading
document.getElementById('pagoForm').addEventListener('submit', function(e) {
    const metodo = document.getElementById('metodoHidden').value;
    if (!metodo) {
        e.preventDefault();
        Swal.fire({ icon:'warning', title:'Selecciona un método de pago',
            background:'#111827', color:'#e2e8f0', confirmButtonColor:'#2563eb' });
        return;
    }
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Procesando...';
});
</script>
@endpush
