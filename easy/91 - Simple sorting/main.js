// https://www.codeeval.com/open_challenges/91/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' ');
        tmp.sort(function(a,b){
            return a-b;
        });
        console.log( tmp.join(' ') );
    }
});