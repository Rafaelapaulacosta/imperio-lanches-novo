@extends('layouts.app')

@section('title', 'Novo Pedido')

@section('breadcrumb')
    Pedidos / Novo Pedido
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">📦 Novo Pedido</h1>

        <p class="page-subtitle">
            Preencha os dados e adicione os itens do pedido.
        </p>
    </div>

    <a href="{{ route('pedidos.index') }}"
       class="btn btn-light">
        <i class="bi bi-arrow-left me-1"></i>
        Voltar
    </a>
</div>

<form action="{{ route('pedidos.store') }}" method="POST">

    @csrf

    <div class="card mb-4">

        <div class="card-header">
            <h2 class="card-title-sm">
                Informações do Pedido
            </h2>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label for="cliente" class="form-label">
                    Cliente
                </label>

                <input
                    type="text"
                    id="cliente"
                    name="cliente"
                    class="form-control"
                    value="{{ old('cliente') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="forma_pagamento" class="form-label">
                    Forma de pagamento
                </label>

                <select
                    id="forma_pagamento"
                    name="forma_pagamento"
                    class="form-select"
                    required>

                    <option value="">Selecione</option>
                    <option value="PIX">PIX</option>
                    <option value="Dinheiro">Dinheiro</option>
                    <option value="Cartão">Cartão</option>
                </select>
            </div>

            <div>
                <label for="observacao" class="form-label">
                    Observação
                </label>

                <textarea
                    id="observacao"
                    name="observacao"
                    class="form-control"
                    rows="3">{{ old('observacao') }}</textarea>
            </div>

        </div>
    </div>

    <div class="card mb-4">

        <div class="card-header">
            <h2 class="card-title-sm">
                Itens do Pedido
            </h2>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Lanche</th>
                            <th width="130">Quantidade</th>
                            <th width="150">Preço</th>
                            <th width="150">Subtotal</th>
                            <th width="80">Ação</th>
                        </tr>
                    </thead>

                    <tbody id="itensPedido">

                        <tr class="linha-item">

                            <td>
                                <select
                                    name="itens[0][item]"
                                    class="form-select item-select"
                                    required>

                                    <option value="">Selecione um item</option>

                                    <optgroup label="Lanches">

                                        @foreach ($lanches as $lanche)

                                            <option
                                                value="lanche-{{ $lanche->id }}"
                                                data-id="{{ $lanche->id }}"
                                                data-tipo="lanche"
                                                data-preco="{{ $lanche->preco }}">

                                                {{ $lanche->nome }}

                                            </option>

                                        @endforeach

                                    </optgroup>

                                    <optgroup label="Refrigerantes">

                                        @foreach ($refrigerantes as $refrigerante)

                                            <option
                                                value="refrigerante-{{ $refrigerante->id }}"
                                                data-id="{{ $refrigerante->id }}"
                                                data-tipo="refrigerante"
                                                data-preco="{{ $refrigerante->preco }}">

                                                {{ $refrigerante->nome }}

                                            </option>

                                        @endforeach

                                    </optgroup>
                                
                                </select>
                            </td>

                            <td>
                                <input
                                    type="number"
                                    name="itens[0][quantidade]"
                                    class="form-control quantidade"
                                    value="1"
                                    min="1"
                                    required>
                            </td>

                            <td>
                                <input
                                    type="text"
                                    class="form-control preco"
                                    value="0,00"
                                    readonly>
                            </td>

                            <td>
                                <input
                                    type="text"
                                    class="form-control subtotal"
                                    value="0,00"
                                    readonly>
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="btn btn-success btn-adicionar"
                                    title="Adicionar item">

                                    <i class="bi bi-plus-lg"></i>

                                </button>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-end">

                <div class="fs-5 fw-bold">
                    Total: R$
                    <span id="valorTotal">0,00</span>
                </div>

            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">

        <a href="{{ route('pedidos.index') }}"
           class="btn btn-light">
            Cancelar
        </a>

        <button type="submit"
                class="btn btn-primary">
            Salvar Pedido
        </button>

    </div>

</form>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const tabelaItens = document.getElementById('itensPedido');
    const valorTotal = document.getElementById('valorTotal');


    // Formata valores para moeda brasileira
    function formatarMoeda(valor) {

        return Number(valor).toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

    }


    // Atualiza preço e subtotal de uma linha
    function atualizarLinha(linha) {

        const selectItem = linha.querySelector('.item-select');
        const campoQuantidade = linha.querySelector('.quantidade');
        const campoPreco = linha.querySelector('.preco');
        const campoSubtotal = linha.querySelector('.subtotal');

        const opcaoSelecionada =
            selectItem.options[selectItem.selectedIndex];

        const preco = Number(
            opcaoSelecionada?.dataset.preco || 0
        );

        const quantidade = Number(
            campoQuantidade.value || 0
        );

        const subtotal = preco * quantidade;

        campoPreco.value = formatarMoeda(preco);

        campoSubtotal.value = formatarMoeda(subtotal);

        atualizarTotal();
    }


    // Calcula o valor total do pedido
    function atualizarTotal() {

        let total = 0;

        const linhas =
            tabelaItens.querySelectorAll('.linha-item');

        linhas.forEach(function (linha) {

            const selectItem =
                linha.querySelector('.item-select');

            const campoQuantidade =
                linha.querySelector('.quantidade');

            const opcaoSelecionada =
                selectItem.options[selectItem.selectedIndex];

            const preco = Number(
                opcaoSelecionada?.dataset.preco || 0
            );

            const quantidade = Number(
                campoQuantidade.value || 0
            );

            total += preco * quantidade;

        });

        valorTotal.textContent =
            formatarMoeda(total);
    }


    // Reorganiza os nomes dos inputs
    function reindexarLinhas() {

        const linhas =
            tabelaItens.querySelectorAll('.linha-item');

        linhas.forEach(function (linha, indice) {

            const selectItem =
                linha.querySelector('.item-select');

            const quantidade =
                linha.querySelector('.quantidade');

            selectItem.name =
                `itens[${indice}][item]`;

            quantidade.name =
                `itens[${indice}][quantidade]`;

        });

    }


    // Cria uma nova linha de item
    function criarNovaLinha(linhaAtual) {

        const selectAtual =
            linhaAtual.querySelector('.item-select');

        if (!selectAtual.value) {

            alert('Selecione um item antes de adicionar outro.');

            return;
        }


        const novaLinha =
            linhaAtual.cloneNode(true);


        const novoSelect =
            novaLinha.querySelector('.item-select');

        const novaQuantidade =
            novaLinha.querySelector('.quantidade');

        const novoPreco =
            novaLinha.querySelector('.preco');

        const novoSubtotal =
            novaLinha.querySelector('.subtotal');

        const novoBotao =
            novaLinha.querySelector('button');


        // Limpa a nova linha

        novoSelect.value = '';

        novaQuantidade.value = 1;

        novoPreco.value = '0,00';

        novoSubtotal.value = '0,00';


        // Botão da nova linha continua sendo +

        novoBotao.className =
            'btn btn-success btn-adicionar';

        novoBotao.title =
            'Adicionar item';

        novoBotao.innerHTML =
            '<i class="bi bi-plus-lg"></i>';


        // Botão da linha anterior vira excluir

        const botaoAtual =
            linhaAtual.querySelector('button');

        botaoAtual.className =
            'btn btn-danger btn-remover';

        botaoAtual.title =
            'Remover item';

        botaoAtual.innerHTML =
            '<i class="bi bi-trash"></i>';


        // Adiciona nova linha na tabela

        tabelaItens.appendChild(novaLinha);

        reindexarLinhas();

    }


    // Quando mudar produto ou quantidade

    tabelaItens.addEventListener('change', function (event) {

        if (
            event.target.classList.contains('item-select') ||
            event.target.classList.contains('quantidade')
        ) {

            const linha =
                event.target.closest('.linha-item');

            atualizarLinha(linha);

        }

    });


    // Quando digitar a quantidade

    tabelaItens.addEventListener('input', function (event) {

        if (event.target.classList.contains('quantidade')) {

            const linha =
                event.target.closest('.linha-item');

            atualizarLinha(linha);

        }

    });


    // Botões adicionar e remover

    tabelaItens.addEventListener('click', function (event) {

        const botaoAdicionar =
            event.target.closest('.btn-adicionar');


        if (botaoAdicionar) {

            const linha =
                botaoAdicionar.closest('.linha-item');

            criarNovaLinha(linha);

            return;

        }


        const botaoRemover =
            event.target.closest('.btn-remover');


        if (botaoRemover) {

            const linha =
                botaoRemover.closest('.linha-item');

            linha.remove();

            reindexarLinhas();

            atualizarTotal();

        }

    });

});

</script>

@endsection