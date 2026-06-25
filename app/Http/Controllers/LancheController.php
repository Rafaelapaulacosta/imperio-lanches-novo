<?php

namespace App\Http\Controllers;

use App\Models\Lanche;
use Illuminate\Http\Request;

class LancheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $busca = $request->busca;

         $lanches = Lanche::query();

         if ($busca) {
               $lanches->where(function ($query) use ($busca) {
                  $query->where('nome', 'like', "%{$busca}%")
                   ->orWhere('descricao', 'like', "%{$busca}%");
        });
    }

    $lanches = $lanches->paginate(10);

    return view('Lanches.index', compact('lanches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Lanches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->merge([
            'preco' => str_replace(',', '.', str_replace('.', '', $request->preco))
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:400',
            'preco' => 'required|numeric|min:0',
        ]);

        Lanche::create($request->all());

        return redirect()->route('lanches.index')
            ->with('success', 'Lanche criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lanche $lanche)
    {
        return response()->json($lanche);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lanche $lanche)
    {
        return view('Lanches.edit', compact('lanche'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lanche $lanche)
    {

        $request->merge([
            'preco' => str_replace(',', '.', str_replace('.', '', $request->preco))
        ]);
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:400',
            'preco' => 'required|numeric|min:0',
        ]);

        $lanche->update($request->all());

        return redirect()->route('lanches.index')
            ->with('success', 'Lanche alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Lanche = Lanche::findOrFail($id);
        $Lanche->delete();

        return redirect()->route('lanches.index')
            ->with('success', 'Lanche excluído com sucesso!');
    }
}
