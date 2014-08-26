// https://www.codeeval.com/open_challenges/16/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var bin = parseInt(line, 10).toString(2);
        console.log(bin.split('1').length - 1 );
    }
});