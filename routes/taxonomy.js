var express = require('express');
const path = require('path');
const fs   = require('fs');
const readline = require('readline');

var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('taxonomy');
});

router.get('/:category/:alp',function(req, res, next){
  //resources/[A-Z].txtを開いて読み取る
  //読み取ったデータをリストとして渡す
  /*
  * req.params = {
    category : family|genus|species
    alp      : [A-Z]
  }
  */
  function readData(){
    return new Promise(function(resolve,reject){
      let retList = [] ;
      let cat = req.params.category;
      infile = path.join(__dirname,'..','public','resources','rbcL','category',`${cat}.txt`)
      let rs = fs.createReadStream(infile,encoding = 'utf-8');//streamの作成
      let rl = readline.createInterface({input:rs});
     
      rl.on('error',function(){
        reject(err);
      })
    
      rl.on('close',function(){
        retList.sort(function(a,b){
          if(a.NAME>b.NAME){
            return -1;
          }else{
            return 1;
          }
        })
        let retObj = {
          CATEGORY:req.params.category,
          ALP:req.params.alp,
          ELEM:retList
        }
        resolve(retObj);
      })

      rl.on('line',function(line){
        let name='';
        let allcount=0;
        let curacount=0;

        if(line[0]==req.params.alp){
          [name,allcount,curacount]=line.split('\t');
          retList.push({
            NAME:name,
            ALL:allcount,
            CURATED:curacount
          })

        }else if(req.params.alp=='x'){
          if($line[0] != /^[A-Z]/){
            [name,allcount,curacount]=line.split('\t');
            letList.push({
              NAME:name,
              ALL:allcount,
              CURATED:curacount
            })
          }
        }    
      })
    })
  }

  Promise.resolve()
    .then(function(){
      return readData();
    })
    .then(function(retObj){
      res.render('taxonomyCat',{
        taxcatobj:retObj
      });
    })
    .catch(function(err){
      res.send(err.toString);
    });


  
})

module.exports = router;
