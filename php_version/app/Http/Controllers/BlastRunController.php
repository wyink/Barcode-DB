<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB ;

class BlastRunController extends Controller
{
    /**
     * Do blast application based on the user request
     * @return mixed : the output shown in the result page.
     */
    public function index(){
        $resultObj = BlastRunController::makeRelation(
            BlastRunController::showResultBlast(),
            BlastRunController::readCatFile()
        );
        return view('blastResult',[
            'blastLineArray'=> $resultObj
        ]);
    }
    
    /**
     * create fileName randommly
     * we need to create filename everytime user request so that we can identify user's request
     * @return string
     */
    private static function getfileName():string{
        $randomNum = rand(0,10000);//to string automatically
        return strval($randomNum);
    }

    /**
     * write user input sequense into the file temporary
     * @param string $fileName
     */
    private static function outQryToText(string $fileName):void{
        $publicPath = public_path();
        $inFile = "{$publicPath}/resources/temp/{$fileName}.fasta";
        $query = $_POST['query'];//get sequences user inputs
        file_put_contents($inFile,$query,LOCK_EX);
    }


    /**
     * Run blast application on the server and return the result
     * @param string $fileName:file name the application result will be written into.
     * @return string :the path to the file app result written in.
     */
    private static function BlastRunController(string $fileName):string{
        $publicPath = public_path();
        $basePath = base_path();
        $inFileName=  "{$publicPath}/resources/temp/{$fileName}.fasta";
        $outResultFile = "{$publicPath}/resources/temp/{$fileName}_result.txt";
        $db         = $_POST['db'];
        $gene       = $_POST['gene'];
        $prePath = str_replace("php_version","public",$basePath);
        $blastDb    = "{$prePath}/resources/{$gene}/db/{$db}/all" ;
        $outFmtOpt  = '"6 std qlen slen"' ;
        $maxTagSeq  = 100;

        $cmd = "blastn -query {$inFileName}  -db {$blastDb} -out {$outResultFile} -outfmt {$outFmtOpt} -max_target_seqs {$maxTagSeq}";
        exec($cmd);
        return $outResultFile;
    }

    /**
     * Read the file application written into and sort out the content then return.
     * @param string $outputFile
     * @return array :the Format is below.
     * array(
     *      'perIdent'=>[
     *      'RSTART'=> '',
     *      'REND'=>''
     *      ],
     *      'objArrayIn'=>[
     *                 [
     *                     'URL'=>"https://www.ncbi.nlm.nih.gov/protein/{$ref}", 
     *                     'REF'=>$ref       ,     
     *                     'SPE'=>'' ,             
     *                     'IDEN'=>$identity ,     
     *                     'ALEN'=>$alignLen ,     
     *                     'MM'=>$missMatch  ,     
     *                     'GA'=>$gapOpen    ,     
     *                     'QS'=>$qstart     ,     
     *                     'QE'=>$qend       ,     
     *                     'RS'=>$rstart     ,     
     *                     'RE'=>$rend       ,     
     *                     'EV'=>$eval       ,     
     *                     'BS'=>$bitScore   ,     
     *                 ],...
     *             ]
     *         )
     */
    private static function readResultFile(String $outputFile):?array{
        $counter = 0; 
        $perIdent = [
            'RSTART' => '', 
            'REND'=>''     
        ];
        $objArrayIn=[];//2 dimentions array. Each item equals to the 1 blast result row.
        $resultFile = fopen($outputFile,"r"); // The file Blast application output.
        if(!$resultFile){
                echo("The file doesn't exist.");
                return null;
        }else{
            while($line = fgets($resultFile)){
                $counter++;

                $_ = explode("\t",$line);
                $ref        =$_[1];       
                $identity   =$_[2];
                $alignLen   =$_[3];
                $missMatch  =$_[4];
                $gapOpen    =$_[5];
                $qstart     =$_[6];
                $qend       =$_[7];
                $rstart     =$_[8];
                $rend       =$_[9];
                $eval       =$_[10];
                $bitScore   =$_[11];

                //1st line means tophit query shown differently in the site.
                if($counter==1){
                    $maxSeqs = 1035;//The max length of the gene seq is 1035
                    $displayStart= '0';//the start positon of refseq to display in SVG file
                    $_ = ((abs($rstart-$rend))/$maxSeqs)*100; //the End positon of refseq to display in SVG file
                    if($_ >=100){
                        $displayEnd='100';
                    }else{
                        $displayEnd = strval($_);
                    }
                    $perIdent['RSTART']= $displayStart;
                    $perIdent['REND']= $displayEnd;
                }
                array_push($objArrayIn,[
                        'URL'=>"https://www.ncbi.nlm.nih.gov/protein/{$ref}", 
                        'REF'=>$ref       ,     
                        'SPE'=>'' ,     
                        'IDEN'=>$identity ,     
                        'ALEN'=>$alignLen ,     
                        'MM'=>$missMatch  ,     
                        'GA'=>$gapOpen    ,     
                        'QS'=>$qstart     ,     
                        'QE'=>$qend       ,     
                        'RS'=>$rstart     ,     
                        'RE'=>$rend       ,     
                        'EV'=>$eval       ,     
                        'BS'=>$bitScore   ,
                    ]
                );
            }
        }

        return [
            'perIdent'=>$perIdent,
            'objArrayIn'=>$objArrayIn
        ];
    }

    /**
     * check if we could get the result after the blast
     * @param string $qryText
     * @return bool
     */
    private static function isOutput(String $qryText):bool{
        if(file_exists($qryText)){
            if(filesize($qryText) <= 0){
                return false;
            }else{
                return true;
            }
        }else{
            echo "The file doesn't exist.";
            return false;
        }
    }


    /**
     * This gets user requsted category data from SQLServer.
     * @return array : Format is below.
     *  $refTaxArray = array(
     *      "referenceID" = [taxid,sp,ge,fm,ph];
     *  )
     *  
     */
    private static function readCatFile():?array{
        $gene = $_POST['gene'] ;
        $db = $_POST['db'];
        $refTaxArray = null; 

        $items='';
        $isCurated=0;
        if($gene=='rbcL'){
            if($db=='curated'){
                $isCurated=1;
                $items = DB::table('category_rbcL')->where('isCurated',$isCurated)->get();
            }else{
                $items = DB::table('category_rbcL')->get();
            }
        }else{//matK
            if($db=='curated'){
                $isCurated=1;
                $items = DB::table('category_matK')->where('isCurated',$isCurated)->get();
            }else{
                $items = DB::table('category_matK')->get();
            }
            
        }
        
        foreach($items as $item){
            $refTaxArray[$item->geneID] = array(
                $item->taxID,
                $item->species,
                $item->genus,
                $item->family,
                $item->phylum
            );    
        }

        return $refTaxArray;
    }

    /**
     * Return customized blast app result by calling several function.
     * @return array
     */
    private static function showResultBlast():?array{
        $outFile = BlastRunController::getfileName();
        BlastRunController::outQryToText($outFile);
        $resultObj = null;
        $resultFile = BlastRunController::BlastRunController($outFile);
        if(BlastRunController::isOutput($resultFile)){
            $resultObj = BlastRunController::readResultFile($resultFile);
            $resultObj['QueryID'] = "Query_{$outFile}";
        }
        return $resultObj;

    }

    /**
     * The blast app data is not include category data.
     * This func will make relations between each data and category
     * @param array $resultObj:blast app result included
     * @param array $refTaxarray:category data included
     * @return array : result with categorydata
     */
    private static function makeRelation($resultObj,$refTaxArray):?array{
        if($resultObj==null||$refTaxArray==null){
            return null;
        }

        $resultObj['topRef'] = [
            'TAXID'=>'',
            'SPECIES'=>'',
            'GENUS'=> '',
            'FAMILY'=> '',
            'PHYLUM'=>'',
        ];
 
        $resultObj['topRef']['TAXID'] = $refTaxArray[$resultObj['objArrayIn'][0]['REF']][0];
        $resultObj['topRef']['SPECIES'] = $refTaxArray[$resultObj['objArrayIn'][0]['REF']][1];
        $resultObj['topRef']['GENUS']   = $refTaxArray[$resultObj['objArrayIn'][0]['REF']][2];
        $resultObj['topRef']['FAMILY']  = $refTaxArray[$resultObj['objArrayIn'][0]['REF']][3];
        $resultObj['topRef']['PHYLUM'] = $refTaxArray[$resultObj['objArrayIn'][0]['REF']][4];
        
        foreach($resultObj['objArrayIn'] as &$record){
            $record['SPE'] = $refTaxArray[$record['REF']][1];
        }

        return $resultObj;

    }
}