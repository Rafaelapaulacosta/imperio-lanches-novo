<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use App\Models\Animal;

class AnimalController extends Controller
{
    public function index(){

    $animals =  Animal::all();
    return view('animais.index', compact('animals'));

    }

    public function create(){
        return view('animais.create');
    }

    public function store(Request $request){
        
        Animal::create([
            'nome' => $request->nome,
            'especie' => $request->especie,
            'idade' => $request->idade
        ]

        );

            return redirect('/animais');
    }
}
