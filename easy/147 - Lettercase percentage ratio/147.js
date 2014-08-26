// https://www.codeeval.com/open_challenges/156/
var fs  = require("fs");
fs.readFileSync(process.argv[2]).toString().split('\n').forEach(function (line) {
    line = line.trim();
    if( line != '' ){
        var len = line.length;
        var alpha = 'AZ';
        var A = alpha.charCodeAt(0);
        var Z = alpha.charCodeAt(1);
        var i = len;
        var upper = 0;
        while(i--){
            var ord = line.charCodeAt(i);
            if( ord >= A && ord <= Z ){
                upper++;
            }
        }
        console.log('lowercase: ' + ((len-upper)*100/len).toFixed(2) + ' uppercase: ' + (upper*100/len).toFixed(2) );
    }
});