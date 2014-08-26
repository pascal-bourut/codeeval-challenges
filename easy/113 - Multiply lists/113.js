// https://www.codeeval.com/open_challenges/113/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(' | ');
        var left = tmp[0].split(' ');
        var right = tmp[1].split(' ');
        var results = [];
        for( var i=0, nb=left.length ; i < nb ; i++){
            results.push( Number(left[i]) * Number(right[i]) );
        }
        console.log(results.join(' '));
    }
});