var express = require('express');
var router = express.Router();

router.post('/',function(req,res,next){
    //res.send(req.body);
    //引数が正しいかどうかを確認する

    const validSampleGeneArray = ['0','1','2'];
    const isValidSampleGene = (element) => element == req.body.sampleGene;
    
    const validGene = ['matK','rbcL'];
    const isValidGene = (element) => element == req.body.gene;

    const valudDb = ['curated','All'] ;
    const isValidDb = (element) => element == req.body.db

    for(i:[isValidSampleGene,isValidGene,isValidDb])        
    //2000文字以下      
    const mQuery      = req.body.query;


})

module.exports = router;