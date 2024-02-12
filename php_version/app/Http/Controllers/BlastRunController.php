<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlastRunController extends Controller
{
    public function index(){
        /*
        blast実行時のメソッド
        pre処理は値のvalidationで実施
        post処理はhtmlの整形処理
        このコントローラーでは何を実施する？
        後々はDBからデータ取得等
        今：
        １．ファイル名を生成
        ２．ファイルを書き出し
        ３．blast実行
        ４．ファイルサイズ確認
        ５．resultファイル読み出し＝＞DB登録？
        ６．種別ファイル読み出し
        ７．５と６の紐づけ
        ８．結果の表示＝＞postのmiddlewareにて実装
        コントローラとしてルートから呼び出されるものシングルメソッドにしておく。
        それ以外はprivateとして関数を分割する。
        */

        $resultObj = BlastRunController::makeRelation(
            BlastRunController::showResultBlast(),
            BlastRunController::readCatFile()
        );
        return view('blastResult',[
            'blastLineArray'=> $resultObj
        ]);
    }
    
    private static function getfileName():string{
        $randomNum = rand(0,10000);//to string automatically
        return strval($randomNum);
    }

    /*
        Write user input sequence to the local file 
        File name is randomly generated.
    */
    private static function outQryToText(string $fileName):void{
        $publicPath = public_path();
        $inFile = "{$publicPath}/resources/temp/{$fileName}.fasta";
        $query = $_POST['query'];//get sequences user inputs
        file_put_contents($inFile,$query,LOCK_EX);
    }

    /*
        Run the Blast application on the server and return the result.
        @arg $fileName:result file name generated by the function
        @return $outResultFile: the path to the result file
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

    /*
        @return 
        array(
            'perIdent'=>[
                'RSTART'=> '',
                'REND'=>''
            ],
            'objArrayIn'=>[
                [
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
                ],...
            ]
        )
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

        //after reading file
        return [
            'perIdent'=>$perIdent,
            'objArrayIn'=>$objArrayIn
        ];
    }

    //check if we could get the result after the blast
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

    /*
        @return 
        $refTaxArray = array(
            "referenceID" = [taxid,sp,ge,fm,ph];
        )
    */
    private static function readCatFile():?array{
        $gene = $_POST['gene'] ;
        $db = $_POST['db'];

        $basePath = base_path();
        $prePath = str_replace("php_version","public",$basePath);
        $fpath = "{$prePath}/resources/{$gene}/info/{$db}.txt";
        $refTaxArray = null; 


        $resultFile = fopen($fpath,"r");
        while($line = fgets($resultFile)){
            // AUT83098.1	440359	sp|Campanula patula ge|Campanula fm|Campanulaceae ph|Streptophyta
            preg_match_all(
                '/^([A-Z]+\d+\.\d)\t(\d+)\tsp\|(.+) ge\|(.+) fm\|(.+) ph\|(.+)$/',
                $line,
                $matches,
                PREG_PATTERN_ORDER
            );
            $ref    =$matches[1][0];
            $taxid  =$matches[2][0];
            $sp     =$matches[3][0];
            $ge     =$matches[4][0];
            $fm     =$matches[5][0];
            $ph     =$matches[6][0];
            $refTaxArray[$ref] = array($taxid,$sp,$ge,$fm,$ph);
        }
        return $refTaxArray;
    }

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
 
        

        /*
            $refTaxArray = array(
                "referenceID" = [taxid,sp,ge,fm,ph];
            )
            $resultObj =  array(
                'QueryID' = >'',
                'perIdent'=>['RSTART'=>'~%','REND'=>'~%']
                'objArrayIn'=>[
                    [
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
                    ],...
                ]
            )
        */
        $TMP = $resultObj['objArrayIn'];
        $TMP = $resultObj['objArrayIn'][0];
        $TMP = $resultObj['objArrayIn'][0]['REF'];
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