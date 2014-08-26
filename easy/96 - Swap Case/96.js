// https://www.codeeval.com/open_challenges/96/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var len = line.length;
        var newline = '';
        var alpha = 'azAZ';
        var a = alpha.charCodeAt(0);
        var z = alpha.charCodeAt(1);
        var A = alpha.charCodeAt(2);
        var Z = alpha.charCodeAt(3);
        for(var i=0 ; i < len ; i++){
            var char = line.charAt(i);
            var ord = line.charCodeAt(i);
            if( ord >= a && ord <= z ){
                char = char.toUpperCase();
            }
            else if( ord >= A && ord <= Z ){
                char = char.toLowerCase();
            }
            newline += char;
        }
        console.log(newline);
    }
});