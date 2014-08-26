// https://www.codeeval.com/open_challenges/31/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        console.log(tmp[0].lastIndexOf(tmp[1]));
    }
});