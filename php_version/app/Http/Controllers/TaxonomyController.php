<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB ;

class TaxonomyController extends Controller
{
    /**
     * Get the specific data that matches users request(category,first alphabet) from SQLServer
     * @param string $category :use can select 3 options(species,genus,family)
     * @param string $alp :the first alphabet of each category user selected'
     * @return mixed
     */
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