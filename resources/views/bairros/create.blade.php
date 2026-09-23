@extends('layouts.app')

@section('title', 'Novo Bairro')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('bairros.index') }}">Bairros</a>
    </li>
    <li class="breadcrumb-item active">Novo Bairro</li>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">🍔 Novo Bairro</h1>
        <p class="page-subtitle">
            Preencha os dados para cadastrar um novo bairro.
        </p>
    </div>

    <a href="{{ route('bairros.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left me-1"></i>
        Voltar
    </a>
</div>

<div class="card">

    <div class="card-header">
        <h2 class="card-title-sm">
            <i class="bi bi-pencil-square" style="color:#f97316;"></i>
            Cadastro de Bairro
        </h2>
    </div>

    <div class="card-body">

        <form action="{{ route('bairros.store') }}" method="POST">

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
                    placeholder="Digite o nome do bairro">

                @error('nome')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

 

            <div class="mb-4">
                <label for="valor_frete" class="form-label fw-semibold">
                    Valor do Frete
                </label>

                <input
                    type="text"
                    id="valor_frete"
                    name="valor_frete"
                    value="{{ old('valor_frete') }}"
                    class="form-control"
                    placeholder="0,00">

                @error('valor_frete')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('bairros.index') }}"
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

    const valor_frete = document.getElementById('valor_frete');

    valor_frete.addEventListener('input', function () {

        let valor = this.value.replace(/\D/g, '');

        valor = (parseInt(valor || 0) / 100).toFixed(2);

        valor = valor.replace('.', ',');

        this.value = valor;
    });

});
</script>

@endsection