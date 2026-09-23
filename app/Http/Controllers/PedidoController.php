<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Lanche;
use App\Models\Refrigerante;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $pedidos = Pedido::with('itens')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lanches = Lanche::orderBy('nome')->get();
        $refrigerantes = Refrigerante::orderBy('nome')->get();

         return view('pedidos.create', compact('lanches', 'refrigerantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    $request->validate([
        'cliente' => 'required|string|max:255',
        'forma_pagamento' => 'required|in:PIX,Dinheiro,Cartão',
        'observacao' => 'nullable|string',
        'itens' => 'required|array|min:1',
        'itens.*.item' => 'required|string',
        'itens.*.quantidade' => 'required|integer|min:1',
    ]);

    DB::transaction(function () use ($request) {

        $valorTotal = 0;
        $itensParaSalvar = [];

        foreach ($request->itens as $item) {

            // "lanche-1" => tipo = lanche, id = 1
            [$tipo, $id] = explode('-', $item['item']);
            $quantidade = (int) $item['quantidade'];

            // Busca o item de verdade no banco (nunca confia no preço do front)
            $model = $tipo === 'lanche'
                ? Lanche::findOrFail($id)
                : Refrigerante::findOrFail($id);

            $subtotal = $model->preco * $quantidade;
            $valorTotal += $subtotal;

            $itensParaSalvar[] = [
                'item_tipo' => $tipo,
                'item_id' => $model->id,
                'item_nome' => $model->nome,
                'preco_unitario' => $model->preco,
                'quantidade' => $quantidade,
                'subtotal' => $subtotal,
            ];
        }

        $pedido = Pedido::create([
            'cliente' => $request->cliente,
            'forma_pagamento' => $request->forma_pagamento,
            'observacao' => $request->observacao,
            'valor_total' => $valorTotal,
        ]);

        $pedido->itens()->createMany($itensParaSalvar);
    });

    return redirect()
        ->route('pedidos.index')
        ->with('success', 'Pedido criado com sucesso!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
