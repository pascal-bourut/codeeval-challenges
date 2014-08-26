// https://www.codeeval.com/open_challenges/99/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var tmp = line.replace(/[^0-9\- ]/g,'').split(' ');
        var x0 = Number(tmp[0]);
        var y0 = Number(tmp[1]);
        var x1 = Number(tmp[2]);
        var y1 = Number(tmp[3]);
        console.log( Math.sqrt( ((x1-x0)*(x1-x0))+((y1-y0)*(y1-y0)) ) );
    }
});