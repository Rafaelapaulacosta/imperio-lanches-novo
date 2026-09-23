<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use Illuminate\Http\Request;

class BairroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $busca = $request->busca;

         $bairros = Bairro::query();

         if ($busca) {
               $bairros->where(function ($query) use ($busca) {
                  $query->where('nome', 'like', "%{$busca}%");
        });
    }

    $bairros = $bairros->paginate(10);

    return view('Bairros.index', compact('bairros'));
        
    }

   
    public function create()
    {
       return view('Bairros.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $request->merge([
            'valor_frete' => str_replace(',', '.', str_replace('.', '', $request->valor_frete))
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'valor_frete' => 'required|numeric|min:0',
        ]);

        Bairro::create($request->all());

        return redirect()->route('bairros.index')
            ->with('success', 'Bairro criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bairro $bairro)
    {
                return response()->json($bairro);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bairro $bairro)
    {
                return view('Bairros.edit', compact('bairro'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bairro $bairro)
    {
        $request->merge([
            'valor_frete' => str_replace(',', '.', str_replace('.', '', $request->valor_frete))
        ]);
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor_frete' => 'required|numeric|min:0',
        ]);

        $bairro->update($request->all());

        return redirect()->route('bairros.index')
            ->with('success', 'Bairro alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bairro = Bairro::findOrFail($id);
        $bairro->delete();

        return redirect()->route('bairros.index')
            ->with('success', 'Bairro excluído com sucesso!');
    }
}
