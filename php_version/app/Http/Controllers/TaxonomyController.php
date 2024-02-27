<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB ;

class TaxonomyController extends Controller
{

    public function index($category,$alp){
        $items = '';
        if($category=='species'){
            $items = DB::table('species_count')->where('speciesName','like',$alp.'%')->get();
        }elseif($category=='genus'){
            $items = DB::table('genus_count')->where('genusName','like',$alp.'%')->get();
        }else{
            $items = DB::table('family_count')->where('familyName','like',$alp.'%')->get();
        }

        return view('taxonomyCat',['items' => $items,'category'=> $category,'alp'=> $alp]);
    }

}