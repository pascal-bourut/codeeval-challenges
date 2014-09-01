// https://www.codeeval.com/open_challenges/146/

var margin = 6;

var fs = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(' ');
        var wire = Number(tmp.shift());
        var d = Number(tmp.shift());
        var cnt = Number(tmp.shift());
        var bats = tmp;
        var from = margin;
        var to = 0;
        var count = 0;
        for(var i = 0 ; i < cnt ; i++){
            var bat = Number(bats[i]);
            to = bat - d;
            if( to >= from ){
                count += Math.floor((to - from) / d) + 1;
            }

            from = bat + d;
        }
        to = wire - margin;
        if( to >= from ){
            count += Math.floor((to - from) / d) + 1;
        }
        console.log(count);
    }
});