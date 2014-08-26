// https://www.codeeval.com/open_challenges/19/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.split(',');
        var n = Number(tmp[0]);
        var p1 = Number(tmp[1]);
        var p2 = Number(tmp[2]);
        var binary = n.toString(2);
        var len = binary.length;    
        console.log( binary.charAt(len-p1) == binary.charAt(len-p2) ? 'true' : 'false' );
    }
});