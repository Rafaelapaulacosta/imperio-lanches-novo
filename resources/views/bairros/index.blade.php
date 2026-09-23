@extends('layouts.app')

@section('title', 'Bairros')

@section('breadcrumb')
    <li class="breadcrumb-item"><span style="color:#94a3b8;">Bairros</span></li>
    <li class="breadcrumb-item active">Bairros</li>
@endsection

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">🍔 Bairros</h1>
        <p class="page-subtitle">Gerencie todos os bairros</p>
    </div>
    <a href="{{ route('bairros.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Novo Bairro
    </a>
</div>

<!-- Alertas de feedback -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 mb-3" role="alert"
         style="background:#dcfce7; color:#15803d;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 mb-3" role="alert"
         style="background:#fee2e2; color:#dc2626;">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Card com tabela -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title-sm">
            <i class="bi bi-list-ul" style="color:#f97316;"></i>
            Lista de Bairros
            <span class="badge rounded-pill ms-1"
                  style="background:#f1f5f9; color:#64748b; font-size:.7rem;">
                {{ $bairros->total() }} itens
            </span>
        </h2>

        <!-- Filtros / Busca -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" action="{{ route('bairros.index') }}" class="d-flex gap-2">
                <input
                    type="search"
                    name="busca"
                    value="{{ request('busca') }}"
                    class="form-control search-input"
                    placeholder="Buscar bairro...">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
                    @if(request()->has('busca'))
                    <a href="{{ route('bairros.index') }}" class="btn"
                       style="border:1px solid #e2e8f0; border-radius:8px; font-size:.85rem; color:#64748b;">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Nome</th>
                    <th>Valor de Frete</th>
                    <th style="width:130px; text-align:center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bairros as $bairro)
                <tr>
                    <td style="color:#94a3b8; font-size:.8rem;">{{ $bairro->id }}</td>
                    <td>
                        <div style="font-weight:600; color:#1e293b;">{{ $bairro->nome }}</div>
                    </td>
                    <td>
                        <span style="font-weight:700; color:#16a34a;">
                            R$ {{ number_format($bairro->valor_frete, 2, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <!-- Ver -->
                            <a 
                               class="btn-action btn-view"
                               title="Visualizar"
                               onclick="visualizarBairro({{ $bairro->id }})">
                                <i class="bi bi-eye"></i>
                            </a>

                            
                            <!-- Editar -->
                            <a href="{{ route('bairros.edit', $bairro) }}"
                               class="btn-action btn-edit"
                               title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <!-- Excluir -->
                            <button type="button"
                                    class="btn-action btn-delete"
                                    title="Excluir"
                                    onclick="confirmarExclusao({{ $bairro->id }}, '{{ addslashes($bairro->nome) }}')">
                                <i class="bi bi-trash3"></i>
                            </button>

                            <!-- Form oculto de exclusão -->
                            <form id="form-delete-{{ $bairro->id }}"
                                  action="{{ route('bairros.destroy', $bairro) }}"
                                  method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div style="font-size:2.5rem; margin-bottom:12px;">🍽️</div>
                        <div style="font-weight:600; color:#334155; margin-bottom:4px;">
                            Nenhum bairro encontrado
                        </div>
                        <div style="font-size:.82rem; color:#94a3b8; margin-bottom:16px;">
                                @if(request()->has('busca'))
                                Tente ajustar os filtros da busca.
                            @else
                                Comece cadastrando o primeiro bairro.
                            @endif
                        </div>
                        <a href="{{ route('bairros.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Cadastrar bairro
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    @if($bairros->hasPages())
    <div class="d-flex align-items-center justify-content-between px-4 py-3"
         style="border-top:1px solid #f1f5f9;">
        <div style="font-size:.8rem; color:#94a3b8;">
            Exibindo {{ $bairros->firstItem() }}–{{ $bairros->lastItem() }}
            de {{ $bairros->total() }} registros
        </div>
        {{ $bairros->withQueryString()->links() }}
    </div>
    @endif
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="modalExcluir" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px; overflow:hidden;">
            <div class="modal-body p-4 text-center">
                <div style="font-size:2.5rem; margin-bottom:12px;">🗑️</div>
                <h5 style="font-weight:700; color:#1e293b; margin-bottom:8px;">Excluir bairro?</h5>
                <p class="text-muted mb-0" style="font-size:.875rem;">
                    Tem certeza que deseja excluir <strong id="nomeExcluir"></strong>?<br>
                    <span style="color:#ef4444;">Esta ação não pode ser desfeita.</span>
                </p>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                <button type="button" class="btn flex-fill"
                        data-bs-dismiss="modal"
                        style="border:1px solid #e2e8f0; border-radius:8px; font-weight:600; color:#64748b;">
                    Cancelar
                </button>
                <button type="button" class="btn flex-fill"
                        id="btnConfirmarExclusao"
                        style="background:#ef4444; color:#fff; border-radius:8px; font-weight:600; border:none;">
                    <i class="bi bi-trash3 me-1"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de visualização -->
<div class="modal fade" id="modalVisualizar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px; overflow:hidden;">
            <div class="modal-body p-4 text-center">
                <div style="font-size:2.5rem; margin-bottom:12px;">👁️</div>
                <h5 style="font-weight:700; color:#1e293b; margin-bottom:8px;">Visualizar bairro</h5>
                <p class="text-muted mb-0" style="font-size:.875rem;">
                    <strong id="nomeVisualizar"></strong><br>
                </p>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                <button type="button" class="btn flex-fill"
                        data-bs-dismiss="modal"
                        style="border:1px solid #e2e8f0; border-radius:8px; font-weight:600; color:#64748b;">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Seu modal aqui -->

<script>
    
function visualizarBairro(id) {
    fetch(`/bairros/${id}`)
        .then(response => response.json())
        .then(data => {

            document.getElementById('nomeVisualizar').textContent = data.nome;

            document.getElementById('valorFreteVisualizar').textContent =
                "R$ " + Number(data.valor_frete).toFixed(2).replace(".", ",");

            const modal = new bootstrap.Modal(
                document.getElementById('modalVisualizar')
            );

            modal.show();
        })
        .catch(error => {
            console.error(error);
            alert('Erro ao carregar os dados do bairro.');
        });
}
</script>

@endsection

@push('scripts')
<script>
    let formIdParaExcluir = null;

    function confirmarExclusao(id, nome) {
        formIdParaExcluir = id;
        document.getElementById('nomeExcluir').textContent = nome;
        new bootstrap.Modal(document.getElementById('modalExcluir')).show();
    }

    document.getElementById('btnConfirmarExclusao').addEventListener('click', function () {
        if (formIdParaExcluir) {
            document.getElementById('form-delete-' + formIdParaExcluir).submit();
        }
    });
</script>
@endpush
