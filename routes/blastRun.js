var express = require('express');
var router = express.Router();

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
        errorComment = "You can submit every one seqs." ;
    }

    if(errorComment != 'NO_ERROR_OCCURED'){
        next();
    }else{
        res.render('error',{
            error_comment:errorComment
        })
        next('Router');
    }
    
})

//2番目のミドルウェア
router.post('/',function(req,res,next){
    const fs = require('fs');

    //blastで利用する入出力ファイル名の決定
    new Promise(function(resolve,reject){
        const randomNum = parseInt(Math.random()*100000);
        const tmpQueryTextName = `${randomNum}.fasta`;
        const tmpOutTextName   = `${randomNum}.txt`;
        resolve([tmpQueryTextName,tmpOutTextName]);
    })
    .then(function([tmpQueryTextName,tmpOutTextName]){
        //ユーザから渡された塩基配列をテキストに書き出し
        return new Promise(function(resolve,reject){       
            fs.writeFile(tmpQueryTextName,req.body.query,function(err){
                if(err){
                    reject(err);
                    return;
                }
                resolve('fileWriteDone!');       
            })
        })
    }).then(function(result){
        res.send(result);
    }).catch(function(err){
        res.send(err.toString);
    });
})
module.exports = router;