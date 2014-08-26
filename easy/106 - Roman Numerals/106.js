// https://www.codeeval.com/open_challenges/106/


var trans = {
    'M' : 1000,
    'CM' : 900,
    'D' : 500,
    'CD' : 400,
    'C' : 100,
    'XC' : 90,
    'L' : 50,
    'XL' : 40,
    'X' : 10,
    'IX' : 9,
    'V' : 5,
    'IV' : 4,
    'I' : 1,
};


var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var number = Number(line);
        var result = '';
        for(var k in trans){
            var v = trans[k];
            var cnt = Math.floor(number / v);
            result += new Array(cnt+1).join(k);
            number = number % v;
        }
        console.log(result);
    }
});