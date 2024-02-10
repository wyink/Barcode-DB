<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blastrun extends Controller
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
        return view("index");
    }
    
    static function getfileName(){
        $randomNum = rand(0,10000);
        return $randomNum;
    }

    /*
        Write user input sequence to the local file 
        File name is randomly generated.
    */
    static function outQryToText(int $randomNum){
        $file = $randomNum+'.txt';
        $query = $_POST['query'];//get sequences user inputs
        file_put_contents($file,$query,LOCK_EX);
    }

    /*
        Run the Blast application on the server and return the result.
    */
    static function blastRun(int $randomNum){
        $inFileName=  app_path()."../{$randomNum}.fasta";
        $outResultFile = $randomNum.'_result.txt';
        $db         = $_POST['db'];
        $gene       = $_POST['gene'];
        $blastDb    = app_path().'..'."public/resources/{$gene}/db/{$db}/all" ;
        $outFmtOpt  = '"6 std qlen slen"' ;
        $maxTagSeq  = 100;

        $cmd = "blastn -query {$inFileName}  -db {$blastDb} -out {$outResultFile} -outfmt {$outFmtOpt} -max_target_seqs {$maxTagSeq}";
        exec($cmd, $output);
        return $outResultFile;
    }

    static function readResultFile($outputFile){
        $counter = 0; //ファイルの一行目のみ別処理  
        $perIdent = [
            'PRSTRAT' => 0, //トップヒットした参照配列のアライメント開始位置（単位は％)
            'PREND'=>0      //トップヒットした参照配列のアライメント終了位置（単位は％）
        ];
        $objArrayIn_=[];//2 dimentions array. Each item equals to the 1 blast result row.
        $resultFile = fopen($outputFile,"r"); // The file Blast application output.
        if(!$resultFile){
                echo("The file doesn't exist.");
                return false;
        }else{
            while($line = fgets($resultFile)){
                echo $line;
                $counter++;

                $_ = explode($line,'\t');
                $ref        =$_[1];// 参照(reference)のID        
                $identity   =$_[2];// アライメントした配列長における一致率
                $alignLen   =$_[3];// アライメント長
                $missMatch  =$_[4];// ミスマッチのカウント
                $gapOpen    =$_[5];// ギャップが生じた箇所のカウント
                $qstart     =$_[6];// クエリのアライメント開始位置
                $qend       =$_[7];// クエリのアライメント終了位置
                $rstart     =$_[8];// 参照のアライメント開始位置
                $rend       =$_[9];// 参照のアライメント終了位置
                $eval       =$_[10];// E-value
                $bitScore   =$_[11];// スコア（大きい方が2つの配列は類似していると言える）

                if(counter==1){
                    
                    $maxSeqs = 1035;//The max length of the gene seq is 1035
                    $displayStart= (rstart/$maxSeqs)*100 + '%';//the start positon of refseq to display in SVG file

                    $displayEnd = '';//the End positon of refseq to display in SVG file
                    $_ = (rend/$maxSeqs)+100;
                    if($_ >100){
                        $displayEnd='100%';
                    }{
                        $displayEnd= "{$_}%";
                    }
                    $perIdent['PRSTRAT']= $displayStart;
                    $perIdent['PREND']=$displayEnd;
                }else{
                    array_push($objArrayIn_,[
                            URL=>"https://www.ncbi.nlm.nih.gov/protein/{$ref}", // 検索結果に表示するURL
                            REF=>$ref       ,     // 参照配列(reference)のID
                            SPE=>'' ,     // 種名
                            IDEN=>$identity ,     // アライメントした配列長における一致率
                            ALEN=>$alignLen ,     // アライメント長
                            MM=>$missMatch  ,     // ミスマッチの総数
                            GA=>$gapOpen    ,     // ギャップが生じた箇所の総数
                            QS=>$qstart     ,     // クエリのアライメント開始位置
                            QE=>$qend       ,     // クエリのアライメント終了位置
                            RS=>$rstart     ,     // 参照のアライメント開始位置
                            RE=>$rend       ,     // 参照のアライメント終了位置
                            EV=>$eval       ,     // E-value値
                            BS=>$bitScore   ,     // ビットスコア（大きい方が2つの配列は類似していると言える）
                        ]
                    );
                }

            }
        }

        //after reading file
        return [
            perIdent=>perIdent_,
            objArrayIn=>objArrayIn_
        ];
    }
}
