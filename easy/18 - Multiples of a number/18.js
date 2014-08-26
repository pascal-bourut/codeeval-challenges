// https://www.codeeval.com/open_challenges/18/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        var x = Number(tmp[0]);
        var n = Number(tmp[1]);
        var i = 0;

        if ( x >= 0 ) {
            while ( i*n < x ) {
                i++;
            }
        } 
        else {
            while ( i*n > x ) {
                i--;
            }
        }
        console.log(n * i);
    }
});