@extends('layouts.app')

@section('title', 'Pedidos')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pedidos</li>
@endsection

@section('content')

<div class="page-header mb-4">

    <div>
        <h1 class="page-title">📦 Pedidos</h1>

        <p class="page-subtitle">
            Acompanhe os pedidos cadastrados.
        </p>
    </div>

    <a href="{{ route('pedidos.create') }}"
       class="btn btn-primary btn-lg">

        <i class="bi bi-plus-circle me-2"></i>
        Novo Pedido

    </a>

</div>


@if($pedidos->isEmpty())

    <div class="alert alert-warning">
        Nenhum pedido cadastrado.
    </div>

@else

    <div class="row g-3">

        @foreach ($pedidos as $pedido)

            <div class="col-12 col-lg-6">

                <div class="card h-100 shadow-sm">

                    <div class="card-body">

                        {{-- Cabeçalho --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>

                                <h2 class="h5 mb-1">
                                    Pedido #{{ $pedido->id }}
                                </h2>

                                <div class="fs-5 fw-semibold">
                                    {{ $pedido->cliente }}
                                </div>

                                <small class="text-muted">
                                    {{ $pedido->created_at?->format('d/m/Y H:i') }}
                                </small>

                            </div>

                            <span class="badge bg-warning text-dark fs-6">
                                {{ $pedido->status ?? 'Pendente' }}
                            </span>

                        </div>


                        <hr>


                        {{-- Itens --}}
                        <div class="mb-3">

                            <div class="fw-semibold mb-2">
                                Itens do pedido
                            </div>

                            @foreach ($pedido->itens as $item)

                                <div class="d-flex justify-content-between mb-2">

                                    <div>
                                        <strong>
                                            {{ $item->quantidade }}x
                                        </strong>

                                        {{ $item->item_nome }}
                                    </div>

                                    <div>
                                        R$ {{ number_format($item->subtotal, 2, ',', '.') }}
                                    </div>

                                </div>

                            @endforeach

                        </div>


                        <hr>


                        {{-- Pagamento --}}
                        <div class="mb-2">

                            <strong>Pagamento:</strong>

                            {{ $pedido->forma_pagamento }}

                        </div>


                        {{-- Observação --}}
                        @if($pedido->observacao)

                            <div class="mb-3">

                                <strong>Observação:</strong>

                                {{ $pedido->observacao }}

                            </div>

                        @endif


                        {{-- Total --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <span class="fs-5 fw-semibold">
                                Total
                            </span>

                            <span class="fs-4 fw-bold">
                                R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
                            </span>

                        </div>


                        <hr>


                        {{-- Ações --}}
                        <div class="d-flex justify-content-end">

                            <a href="{{ route('pedidos.edit', $pedido) }}"
                               class="btn btn-outline-secondary">

                                <i class="bi bi-pencil me-2"></i>
                                Editar Pedido

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endif

@endsection