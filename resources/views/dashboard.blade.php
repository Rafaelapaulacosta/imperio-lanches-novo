@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Visão geral do sistema</p>
    </div>
</div>

<!-- Cards resumo -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:#fff7ed;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">🍔</div>
                <div>
                    <div style="font-size:1.5rem;font-weight:700;color:#1e293b;">24</div>
                    <div style="font-size:.78rem;color:#94a3b8;">Lanches cadastrados</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">✅</div>
                <div>
                    <div style="font-size:1.5rem;font-weight:700;color:#1e293b;">20</div>
                    <div style="font-size:.78rem;color:#94a3b8;">Ativos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:#fef9c3;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">🏷️</div>
                <div>
                    <div style="font-size:1.5rem;font-weight:700;color:#1e293b;">6</div>
                    <div style="font-size:.78rem;color:#94a3b8;">Categorias</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:12px;background:#fff1f2;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">⚠️</div>
                <div>
                    <div style="font-size:1.5rem;font-weight:700;color:#1e293b;">4</div>
                    <div style="font-size:.78rem;color:#94a3b8;">Inativos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-4">
    <p class="text-muted mb-0">Selecione <strong>Lanches</strong> no menu lateral para gerenciar o cardápio.</p>
</div>

@endsection
