// https://www.codeeval.com/open_challenges/62/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        var n = Number(tmp[0]);
        var m = Number(tmp[1]);
        console.log( n - Math.floor(n/m) * m );
    }
});