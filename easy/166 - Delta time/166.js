// https://www.codeeval.com/open_challenges/166/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line !== '' ){
        var tmp = line.split(/[: ]/g);
        
        var a = Math.round(tmp[0]) * 3600 + Math.round(tmp[1]) * 60 + Math.round(tmp[2]);
        var b = Math.round(tmp[3]) * 3600 + Math.round(tmp[4]) * 60 + Math.round(tmp[5]);
        var sec = a>b ? a-b : b-a;
        var hours = parseInt( sec / 3600 ) % 24;
        var minutes = parseInt( sec / 60 ) % 60;
        var seconds = sec % 60;
        var result = (hours < 10 ? '0' + hours : hours) + ':' + (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds  < 10 ? '0' + seconds : seconds);
        console.log( result );
    }
});
