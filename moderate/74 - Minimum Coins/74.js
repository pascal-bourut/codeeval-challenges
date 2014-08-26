// https://www.codeeval.com/open_challenges/67/

var coins = [5,3,1];

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var total = 0;
        var number = Number(line);
        for(var i=0, cnt=coins.length; i < cnt ; i++){
            var v = coins[i];
            var nb = Math.floor(number / v);
            total += nb;
            number %= v;
        }
        console.log(total);
    }
});