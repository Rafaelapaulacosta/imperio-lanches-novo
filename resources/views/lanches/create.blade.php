@extends('layouts.app')

@section('title', 'Novo Lanche')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('lanches.index') }}">Lanches</a>
    </li>
    <li class="breadcrumb-item active">Novo Lanche</li>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">🍔 Novo Lanche</h1>
        <p class="page-subtitle">
            Preencha os dados para cadastrar um novo lanche.
        </p>
    </div>

    <a href="{{ route('lanches.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left me-1"></i>
        Voltar
    </a>
</div>

<div class="card">

    <div class="card-header">
        <h2 class="card-title-sm">
            <i class="bi bi-pencil-square" style="color:#f97316;"></i>
            Cadastro de Lanche
        </h2>
    </div>

    <div class="card-body">

        <form action="{{ route('lanches.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label for="nome" class="form-label fw-semibold">
                    Nome
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    class="form-control @error('nome') is-invalid @enderror"
                    value="{{ old('nome') }}"
                    placeholder="Digite o nome do lanche">

                @error('nome')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label fw-semibold">
                    Descrição
                </label>

                <textarea
                    id="descricao"
                    name="descricao"
                    rows="4"
                    class="form-control @error('descricao') is-invalid @enderror"
                    placeholder="Descreva o lanche">{{ old('descricao') }}</textarea>

                @error('descricao')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="preco" class="form-label fw-semibold">
                    Preço
                </label>

                <input
                    type="text"
                    id="preco"
                    name="preco"
                    value="{{ old('preco') }}"
                    class="form-control"
                    placeholder="0,00">

                @error('preco')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('lanches.index') }}"
                   class="btn btn-light">
                    Cancelar
                </a>

                <button type="submit"
                        class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    Salvar
                </button>

            </div>

        </form>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const preco = document.getElementById('preco');

    preco.addEventListener('input', function () {

        let valor = this.value.replace(/\D/g, '');

        valor = (parseInt(valor || 0) / 100).toFixed(2);

        valor = valor.replace('.', ',');

        this.value = valor;
    });

});
</script>

@endsection