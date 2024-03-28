<?php

namespace App\Http\Controllers;

use App\Models\voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;

class voitureController extends Controller
{
    public function display(){
        $voiture = voiture::all();
        return response()->json($voiture);

    }

    public function estimation(Request $request){
        $request->validate([
            'marque' =>'required', 
            'modele' =>'required', 
            'annee' =>'required' 
        ]);

        $avg = DB::table('voitures')
        ->where('marque', $request->marque)
        ->where('modele', $request->modele)
        ->where('annee', $request->annee)
        ->avg('prix');    

        return response()->json($avg);

    }
}
