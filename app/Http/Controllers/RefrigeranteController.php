<?php

namespace App\Http\Controllers;

use App\Models\Refrigerante;
use Illuminate\Http\Request;

class RefrigeranteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $busca = $request->busca;

         $refrigerantes = Refrigerante::query();

         if ($busca) {
               $refrigerantes->where(function ($query) use ($busca) {
                  $query->where('nome', 'like', "%{$busca}%")
                   ->orWhere('descricao', 'like', "%{$busca}%");
        });
    }

    $refrigerantes = $refrigerantes->paginate(10);

    return view('Refrigerantes.index', compact('refrigerantes'));      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Refrigerantes.create');
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

        Refrigerante::create($request->all());

        return redirect()->route('refrigerantes.index')
            ->with('success', 'Refrigerante criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Refrigerante $refrigerante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Refrigerante $refrigerante)
    {
    return view('Refrigerantes.edit', compact('refrigerante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Refrigerante $refrigerante)
    {

        $request->merge([
            'preco' => str_replace(',', '.', str_replace('.', '', $request->preco))
        ]);
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:400',
            'preco' => 'required|numeric|min:0',
        ]);

        $refrigerante->update($request->all());

        return redirect()->route('refrigerantes.index')
            ->with('success', 'Refrigerante alterado com sucesso!');
    
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Refrigerante $refrigerante)
    {
        $refrigerante->delete();

        return redirect()->route('refrigerantes.index')
            ->with('success', 'Refrigerante excluído com sucesso!');
    
        
    }
}
