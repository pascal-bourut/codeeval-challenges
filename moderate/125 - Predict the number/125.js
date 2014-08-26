// https://www.codeeval.com/open_challenges/125/

var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var n = Number(line);
        var cpt = 0;
        while(n>0){
            var pow = Math.log(n) / Math.log(2);
            var base = Math.pow(2, Math.floor(pow) );
            n = n - base;
            cpt++;
        }
        console.log(cpt%3);
    }
});