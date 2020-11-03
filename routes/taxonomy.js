var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('taxonomy');
});

router.get('/:(family|genus|species)/:([A-Z]{1})',function(req, res, next){
  res.render('taxonomyCat',req.params);
})

module.exports = router;
