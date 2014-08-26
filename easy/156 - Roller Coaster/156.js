// https://www.codeeval.com/open_challenges/156/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        line = line.toLowerCase();
        var len = line.length;
        var newline = '';
        var upper = true;
        var alpha = 'az';
        var min = alpha.charCodeAt(0);
        var max = alpha.charCodeAt(1);
        for(var i=0 ; i < len ; i++){
            var char = line.charAt(i);
            var ord = line.charCodeAt(i);
            if( ord >= min && ord <= max ){
                if( upper ){
                    char = char.toUpperCase();
                }
                upper = !upper
            }
            newline += char;
        }
        console.log(newline);
    }
});