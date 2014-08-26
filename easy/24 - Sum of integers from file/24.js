// https://www.codeeval.com/open_challenges/24/

var total = 0;
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        total += Number(line);
    }
});
console.log(total);