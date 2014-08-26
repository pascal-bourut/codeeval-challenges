// https://www.codeeval.com/open_challenges/21/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var len = line.length;
        var i = len;
        var sum = 0;
        while(i--){
            sum += Number( line.charAt(i) );
        }
        console.log( sum );
    }
});