var express = require('express');
const readline = require('readline');
const child_process = require('child_process');
const fs = require('fs');
const path = require('path');
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
        errorComment = "You can submit once every one seqs.";
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
            const routePath = path.join(__dirname, '..','..','..','..'); //to kagiana
            const pathToBlastn = path.join(routePath,'bin','blastn');
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

    function checkFileSize(out){
        return new Promise(function(resolve,reject){
            if(fs.statSync(out).size == 0){
                res.render('user_error')
                next('Router');
            }else{
                //ファイルサイズが０より大きい場合は次のミドルウェアへ
                resolve(out);
            }
        })
    }

    function readResultFile(out){
        return new Promise(function(resolve,reject){

            let rs = fs.createReadStream(out,encoding = 'utf-8');//streamの作成
            let rl = readline.createInterface({input:rs});
            
            let perIdent_ = {
                PRSTRAT :undefined, //トップヒットした参照配列のアライメント開始位置（単位は％)
                PREND:undefined     //トップヒットした参照配列のアライメント終了位置（単位は％）
            };
            let objArrayIn_ = []; //blast結果各行のデータを要素とする配列
            
            //結果ファイルの一行に含まれる各種パラメータの宣言
            let counter = 0; //ファイルの一行目のみ別処理
            let ref;         // 参照(reference)のID
            let identity;    // アライメントした配列長における一致率
            let alignLen;    // アライメント長
            let missMatch;   // ミスマッチのカウント
            let gapOpen;     // ギャップが生じた箇所のカウント
            let qstart;      // クエリのアライメント開始位置
            let qend;        // クエリのアライメント終了位置
            let rstart;      // 参照のアライメント開始位置
            let rend ;       // 参照のアライメント終了位置
            let eval;        // E-value
            let bitScore;    // スコア（大きい方が2つの配列は類似していると言える）
            
            //読み取りエラー時の処理
            rl.on('error',function(){
                reject(err);
            })

            //読み取り終了-
            rl.on('close',function(){
                resolve({
                    perIdent:perIdent_,
                    objArrayIn:objArrayIn_
                })
            })

            //読み取り-
            rl.on('line',function(line){
                counter++;
                [_,ref,identity,alignLen,missMatch,gapOpen,qstart,qend,rstart,rend,eval,bitScore,_] = line.split('\t');

                if(counter == 1){
                    //svgで表示するための参照のアライメント開始位置（単位は割合）
                    let displayStart = new Promise(function(resolve,reject){
                        const prstart = (parseInt((Number(rstart)/1035)*100,10))+'%';
                        perIdent_.PRSTRAT = prstart;
                    });

                    //svgで表示するための参照のアライメント終了位置（単位は割合）
                    let displayEnd = new Promise(function(resolve,reject){
                        const prend_ = (parseInt((Number(rend)/1035)*100,10));
                        if(prend_ > 100){
                            prend = '100%'; 
                        }else{
                            prend = `${prend_}%` ;
                        }
                        perIdent_.PREND   = prend ;
                    })

                    Promise.all([displayStart,displayEnd])
                        .then(function(){
                            console.log("AlignMentOk");
                        })
                        .catch(function(err){
                            console.log(`AlignMentError: ${err.toString()}`);
                        })

                }else{

                    objArrayIn_.push({
                        URL:`https://www.ncbi.nlm.nih.gov/protein/${ref}`, // 検索結果に表示するURL
                        REF:ref       ,     // 参照配列(reference)のID
                        SPE:undefined ,     // 種名
                        IDEN:identity ,     // アライメントした配列長における一致率
                        ALEN:alignLen ,     // アライメント長
                        MM:missMatch  ,     // ミスマッチの総数
                        GA:gapOpen    ,     // ギャップが生じた箇所の総数
                        QS:qstart     ,     // クエリのアライメント開始位置
                        QE:qend       ,     // クエリのアライメント終了位置
                        RS:rstart     ,     // 参照のアライメント開始位置
                        RE:rend       ,     // 参照のアライメント終了位置
                        EV:eval       ,     // E-value値
                        BS:bitScore   ,     // ビットスコア（大きい方が2つの配列は類似していると言える）
                    })
                }            
            })
        })
    }

    /*
    * @param[refs]: 検索結果の参照ID
    */
    function readCatfile(){
        return new Promise(function(resolve,reject){
            const mGene = req.body.gene ;
            const mDb = req.body.db;

            const routePath = path.join(__dirname, '..');
            const fpath = path.join(routePath ,'public','resources', mGene,`${mDb}.txt`);
            let hash = {}; //key:dbテキストのID val: Taxonomy情報（種・属・科・門）

            let rs = fs.createReadStream(fpath,encoding = 'utf-8');
            let rl = readline.createInterface({input:rs});
    
            rl.on('close',function(){
                resolve(hash);
            })

            rl.on('error',function(){
                reject(err);
            })

            const regex = /^([A-Z]+\d+\.\d)\t(\d+)\tsp\|(.+) ge\|(.+) fm\|(.+) ph\|(.+)$/;
            rl.on('line',function(line){
                // AUT83098.1	440359	sp|Campanula patula ge|Campanula fm|Campanulaceae ph|Streptophyta
                let ref,taxid,sp,ge,fm,ph;
                [_,ref,taxid,sp,ge,fm,ph] = line.match(regex);
                hash[ref] = [taxid,sp,ge,fm,ph];
            })

        })
    }

    function makeRelation(resultObj,hash){
        return new Promise(function(resolve,reject){
            //引数のresultObjにプロパティを追加して返却する
            /*
            resultObj = {
                topRef:{ //トップヒットは種・属・科・門の情報、それ以外は種の情報を渡す
                    TAXID:  undefined,
                    SPECIES:undefined,
                    GENUS:  undefined,
                    FAMILY: undefined,
                    PHYLUM: undefined
                },
                perIdent:{
                    PRSTRAT :undefined, //トップヒットした参照配列のアライメント開始位置（単位は％)
                    PREND:   undefined  //トップヒットした参照配列のアライメント終了位置（単位は％）
                },
                objArrayIn :[ //blast結果各行のデータを要素とする配列
                    {
                        URL:`https://www.ncbi.nlm.nih.gov/protein/${ref}`, // 検索結果に表示するURL
                        REF:ref       ,     // 参照配列(reference)のID
                        SPE:undefined ,     // 種名　
                        IDEN:identity ,     // アライメントした配列長における一致率
                        ALEN:alignLen ,     // アライメント長
                        MM:missMatch  ,     // ミスマッチの総数
                        GA:gapOpen    ,     // ギャップが生じた箇所の総数
                        QS:qstart     ,     // クエリのアライメント開始位置
                        QE:qend       ,     // クエリのアライメント終了位置
                        RS:rstart     ,     // 参照のアライメント開始位置
                        RE:rend       ,     // 参照のアライメント終了位置
                        EV:eval       ,     // E-value値
                        BS:bitScore   ,     // ビットスコア（大きい方が2つの配列は類似していると言える）
                    },{...},...{...}
                ]
            }
            */

            //トップヒットは別表示
            resultObj.topRef = {
                SPECIES:undefined,
                GENUS:  undefined,
                FAMILY: undefined,
                PHYLUM: undefined
            };

            resultObj.topRef.SPECIES = (hash[(resultObj.objArrayIn[0]).REF])[1];
            resultObj.topRef.GENUS   = (hash[(resultObj.objArrayIn[0]).REF])[2];
            resultObj.topRef.FAMILY  = (hash[(resultObj.objArrayIn[0]).REF])[3];
            resultObj.topRef.PHYLUM  = (hash[(resultObj.objArrayIn[0]).REF])[4];
            
            for(const objarrayIn of resultObj.objArrayIn){
                objarrayIn.SPE = (hash[objarrayIn.REF])[1];
            }

            resolve(resultObj);
        })

    }

    async function showResultBlast(){
        const randomNum = await getFileName();
        const outText   = await outQryToText(randomNum);
        let resultObj = await readResultFile('bltest.fasta');
        return resultObj;
    }

    
    Promise.all([showResultBlast(),readCatfile()])
        .then(function([resultObj,hash]){
            return makeRelation(resultObj,hash);
        })
        .then(function(resultObj_){
            console.log(resultObj_);
            res.render('blastResult',{
                blastLineArray:resultObj_
            }); 
        })
        .catch(function(err){
            res.send(err.toString);
        });

})

        /*
        .then(function(randomNum){
            return blastRun(randomNum);
        })
        */
        /*
       .then(function(outText){
        return checkFileSize(outText);
        })
        */

module.exports = router;