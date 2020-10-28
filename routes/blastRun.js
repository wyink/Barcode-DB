var express = require('express');
const readline = require('readline');
const child_process = require('child_process');
const fs = require('fs');
var router = express.Router();

//最初のミドルウェア : 引数の確認
router.post('/',function(req,res,next){

    const mSampleGene = req.body.sampleGene;
    const mGene       = req.body.gene;
    const mDb         = req.body.db;
    const mQuery      = req.body.query;
    let errorComment = 'NO_ERROR_OCCURED' ; //この変数は引数が不正だった場合は上書きされる

    //上三つの引数の確認
    let Argument = [-1,-1,-1];
    Argument[0] = ['0','1','2'].findIndex((element)=> element == mSampleGene);
    Argument[1] = ['matK','rbcL'].findIndex((element)=>element == mGene);
    Argument[2] = ['curated','All'].findIndex((element)=> element == mDb );
    
    for(let i in Argument){
        if(i == -1){
            errorComment = 'Invalid Argument';
        }
    }

    //渡される塩基配列の確認
    if(mQuery.length >= 2000){
        //matKやrbcLは2000bp以下であるため。
        errorComment = "Query-Length have to be under 2000.";
    }else if(mQuery.indexOf('<',0) > 0){
        //scriptタグなどを駆逐
        errorComment = "Invalid character is included." ;
    }else if(mQuery.indexOf('>',1)){
        //一回のsubmitに一つの塩基配列のみ
        errorComment = "You can submit once every one seqs." ;
    }

    if(errorComment != 'NO_ERROR_OCCURED'){
        next();
    }else{
        res.render('user_error_invalid',{
            error_reason:errorComment
        })
        next('Router');
    }
    
})

//2番目のミドルウェア: Blastの実行
router.post('/',function(req,res,next){
    //blastで利用する入出力ファイル名の決定(randomに生成)
    function getFileName(){
        return new Promise(function(resolve,reject){
            const randomNum = parseInt(Math.random()*100000);
            resolve(randomNum);
        });
    };

    //ユーザから渡された塩基配列をテキストに書き出し
    function outQryToText(randomNum){
        return new Promise(function(resolve,reject){       
            fs.writeFile(`${randomNum}.fasta`,req.body.query,function(err){
                if(err){
                    reject(err);
                    return;
                }
                resolve(randomNum);       
            })
        });
    };

    //blastnの実行
    function blastRun(randomNum){
        return new Promise(function(resolve,reject){
            const pathToBlastn = '/home/kagiana/bin/blastn' ;
            const mQuery       = req.body.query;
            const outText      = `${randomNum}.txt`;
            const mDb          = req.body.db;
            const mGene        = req.body.gene;
            const blastdb      = `/blastdb/${mGene}/${mDb}/all` ;
            const outfmtopt    = '"6 std qlen slen"' ;
            const maxTagSeq    = 100;

            const cmd = `${pathToBlastn} -query ${mQuery} -db ${blastdb} -out ${outText} -outfmt ${outfmtopt} -max_target_seqs ${maxTagSeq}`;
            let exec = child_process.exec(cmd,function(err,stdout,stderr){
                if(err){
                    reject(err);
                    return;
                }
            })
            resolve(outText);
        })
    };

    //blast結果の読み出し
    //ファイルがから出なかったらnx;
    function readResultFile(out){
        return new Promise(function(resolve,reject){
            //出力がない場合（ここは同期処理）
            if(fs.statSync(out).size == 0){
                res.render('user_error')
                next('Router');
            }

           　//結果ファイルの解析
            let rs = fs.createReadStream(out);//streamの作成
            let rl = readline.createInterface({input:rs});
            let counter = 0; //ファイルの一行目のみ別処理

            let query;      // クエリ(subject)のID
            let ref;        // 参照(reference)のID
            let identity;   // アライメントした配列長における一致率
            let alignLen;   // アライメント長
            let missMatch;  // ミスマッチのカウント
            let gapOpen;    // ギャップが生じた箇所のカウント
            let qstart;     // クエリのアライメント開始位置
            let qend;       // クエリのアライメント終了位置
            let rstart;     // 参照のアライメント開始位置
            let rend ;      // 参照のアライメント終了位置
            let eval;       // E-value
            let bitScore;   // スコア（大きい方が2つの配列は類似していると言える）
            let qlen ;      // クエリの塩基配列長
            let slen ;      // 参照の塩基配列長

            rl.on('line',function(line){
                //console.log(line);
                counter++;
                [query,ref,identity,alignLen,missMatch,gapOpen,qstart,qend,rstart,rend,eval,bitscore,qlen,slen]
                 = line.split('¥t');
          
                if(counter == 1){
                    //svgで表示するための参照のアライメント開始位置（単位は割合）
                    let prstart = `${parseInt(($rstart/1035)*100)}%`;

                    //svgで表示するための参照のアライメント終了位置（単位は割合）
                    let prend = `${parseInt(($rend/1035)*100)}%`;
                    if(prend > 100){ prend = 100; } 

                    res.locals.prstart = prstart;
                    res.locals.prend   = prend;
   
                }else{
                
                }
                
                
　　
            })
        })
    }



    Promise.resolve()
        .then(function(){
            return getFileName();
        }).then(function(randomNum){
            return outQryToText(randomNum);
        }).then(function(randomNum){
            return blastRun(randomNum);
        }).then(function(outText){
            
            res.render('blastResult',{
                sequrl:'https://www.ncbi.nlm.nih.gov/protein/AOO77654.1',
                seqid:'AAA5555.2'
            });
        }).catch(function(err){
            res.send(err.toString);
        });
})

module.exports = router;