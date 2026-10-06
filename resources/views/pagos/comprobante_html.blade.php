<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago #{{ $pago->id }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 20px;
        }
        .voucher {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,.12);
            width: 100%;
            max-width: 520px;
            overflow: hidden;
        }
        .voucher-header {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            padding: 28px 28px 20px;
            text-align: center;
        }
        .voucher-header .icon {
            font-size: 2.5rem;
            margin-bottom: 8px;
        }
        .voucher-header h2 {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -.01em;
        }
        .voucher-header p {
            font-size: .82rem;
            opacity: .75;
            margin-top: 4px;
        }
        .voucher-amount {
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            border-bottom: 2px dashed #e2e8f0;
        }
        .voucher-amount .label { font-size: .75rem; color: #64748b; text-transform: uppercase; letter-spacing: .06em; }
        .voucher-amount .amount { font-size: 2.4rem; font-weight: 800; color: #059669; line-height: 1.1; }
        .voucher-amount .currency { font-size: 1rem; font-weight: 600; color: #64748b; margin-right: 4px; }
        .voucher-body { padding: 24px 28px; }
        .row-data {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: .88rem;
        }
        .row-data:last-child { border-bottom: none; }
        .row-data .key { color: #64748b; font-weight: 500; }
        .row-data .val { color: #1e293b; font-weight: 600; text-align: right; max-width: 60%; }
        .badge-estado {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 700;
        }
        .badge-aprobado  { background: #d1fae5; color: #065f46; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-rechazado { background: #fee2e2; color: #991b1b; }
        .voucher-footer {
            background: #f8fafc;
            border-top: 2px dashed #e2e8f0;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .voucher-footer .info { font-size: .72rem; color: #94a3b8; }
        .btn-print {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-back {
            background: #e2e8f0;
            color: #475569;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            margin-right: 6px;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .voucher { box-shadow: none; border-radius: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="voucher">

    <div class="voucher-header">
        <div class="icon">🏢</div>
        <h2>Condominio San Diego</h2>
        <p>Comprobante de Pago Oficial · #{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="voucher-amount">
        <div class="label">Monto Pagado</div>
        <div class="amount"><span class="currency">Bs</span>{{ number_format($pago->monto_pagado, 2) }}</div>
    </div>

    <div class="voucher-body">
        <div class="row-data">
            <span class="key">ID de Pago</span>
            <span class="val">#{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="row-data">
            <span class="key">Fecha y hora</span>
            <span class="val">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row-data">
            <span class="key">Método de pago</span>
            <span class="val">{{ ucfirst($pago->metodo ?? 'No especificado') }}</span>
        </div>
        <div class="row-data">
            <span class="key">Estado</span>
            <span class="val">
                @php
                    $est = strtolower($pago->estado ?? 'pendiente');
                    $cls = $est === 'aprobado' ? 'badge-aprobado' : ($est === 'rechazado' ? 'badge-rechazado' : 'badge-pendiente');
                @endphp
                <span class="badge-estado {{ $cls }}">{{ ucfirst($pago->estado ?? 'Pendiente') }}</span>
            </span>
        </div>

        @if($pago->cuota)
        <div class="row-data">
            <span class="key">Concepto</span>
            <span class="val">Cuota — {{ $pago->cuota->titulo ?? 'Cuota mensual' }}</span>
        </div>
        <div class="row-data">
            <span class="key">Residente</span>
            <span class="val">{{ optional($pago->cuota->residente)->nombre_completo ?? '—' }}</span>
        </div>
        @elseif($pago->multa)
        <div class="row-data">
            <span class="key">Concepto</span>
            <span class="val">Multa — {{ Str::limit($pago->multa->motivo, 40) }}</span>
        </div>
        <div class="row-data">
            <span class="key">Titular</span>
            <span class="val">
                {{ optional($pago->multa->residente)->nombre_completo
                   ?? optional($pago->multa->empleado)->nombre_completo
                   ?? '—' }}
            </span>
        </div>
        @endif

        @if($pago->observacion)
        <div class="row-data">
            <span class="key">Observación</span>
            <span class="val">{{ $pago->observacion }}</span>
        </div>
        @endif

        @if($pago->user)
        <div class="row-data">
            <span class="key">Registrado por</span>
            <span class="val">{{ $pago->user->name }}</span>
        </div>
        @endif
    </div>

    <div class="voucher-footer no-print">
        <div class="info">
            Generado el {{ now()->format('d/m/Y H:i') }}<br>
            Sistema Condominio San Diego v2.0
        </div>
        <div>
            <a href="{{ url()->previous() }}" class="btn-back">← Volver</a>
            <button class="btn-print" onclick="window.print()">🖨 Imprimir</button>
        </div>
    </div>

</div>
</body>
</html>
